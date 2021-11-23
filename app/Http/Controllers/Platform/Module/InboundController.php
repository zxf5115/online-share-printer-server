<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Constant\Code;
use App\Models\Common\System\File;
use App\Imports\Inbound\EquipmentImport;
use App\Models\Platform\Module\Inbound\Resource;
use App\Http\Controllers\Platform\BaseController;
use App\Imports\Inbound\EquipmentComparisonImport;
use App\Events\Platform\Inventory\Inbound\FinishEvent;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-11
 *
 * 入库控制器类
 */
class InboundController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Inbound';

  // 客户端搜索字段
  protected $_params = [
    'type',
    'category',
    'create_time',
  ];

  // 关联对象
  protected $_relevance = [
    'member'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-12
   * ------------------------------------------
   * 入库操作第一步
   * ------------------------------------------
   *
   * 入库操作第一步
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function first_step(Request $request)
  {
    $messages = [
      'type.required'      => '请您选择类型',
      'category.required'  => '请您选择入库类型',
      'total.required'     => '请您输入入库数量',
      'operator.required'  => '请您输入操作人',
    ];

    $rule = [
      'type'      => 'required',
      'category'  => 'required',
      'total'     => 'required',
      'operator'  => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $model->organization_id = self::getOrganizationId();
        $model->member_id       = $request->member_id ?: 0;
        $model->type            = $request->type;
        $model->category        = $request->category;
        $model->total           = $request->total;
        $model->operator        = $request->operator;
        $model->active          = 1;
        $model->save();

        $resource = Resource::firstOrNew(['inbound_id' => $model->id]);

        $resource->device_code = $request->device_code ?? '';
        $resource->picture     = $request->picture ?? '';
        $resource->save();

        $url = File::download($request->device_code);

        $url = File::getPhysicalUrl($url);

        // 导入设备数据
        Excel::import(new EquipmentImport($model->id, $request->member_id), $url);

        File::destroy($url);

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-12
   * ------------------------------------------
   * 入库操作第二步
   * ------------------------------------------
   *
   * 入库操作第二步
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function second_step(Request $request)
  {
    $messages = [
      'id.required'                    => '请您输入入库单编号',
      'device_code_warehouse.required' => '请您上传盘点设备码',
    ];

    $rule = [
      'id'                    => 'required',
      'device_code_warehouse' => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $model->active = 2;
        $model->save();

        $resource = Resource::firstOrNew(['inbound_id' => $request->id]);

        $resource->device_code_warehouse = $request->device_code_warehouse ?? '';
        $resource->save();

        $url = File::download($request->device_code_warehouse);

        $url = File::getPhysicalUrl($url);

        // // 导入设备数据
        Excel::import(new EquipmentComparisonImport($model->id, $model->member_id), $url);

        File::destroy($url);

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-12
   * ------------------------------------------
   * 入库操作第三步
   * ------------------------------------------
   *
   * 入库操作第三步
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function third_step(Request $request)
  {
    $messages = [
      'id.required' => '请您输入入库单编号',
    ];

    $rule = [
      'id' => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $model = $this->_model::getRow(['id' => $request->id]);

        $model->active = 3;
        $model->save();

        $resource = Resource::firstOrNew(['inbound_id' => $model->id]);

        $resource->receipt_form = $request->receipt_form ?? '';
        $resource->save();

        // 完成入库
        event(new FinishEvent($request->id));

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
