<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Constant\Code;
use App\Imports\Outbound\EquipmentImport;
use App\Models\Common\System\File;
use App\Events\Platform\Printer\BindEvent;
use App\Http\Controllers\Platform\BaseController;
use App\Models\Platform\Module\Outbound\Resource;
use App\Models\Platform\Module\Outbound\Logistics;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-11
 *
 * 出库控制器类
 */
class OutboundController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Outbound';

  // 客户端搜索字段
  protected $_params = [
    'type',
    'category',
    'create_time',
  ];


  // 附加关联查询条件
  protected $_addition = [
    'member' => [
      'username',
      'nickname',
    ]
  ];


  // 关联对象
  protected $_relevance = [
    'member'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-12
   * ------------------------------------------
   * 操作信息
   * ------------------------------------------
   *
   * 操作信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function first_step(Request $request)
  {
    $messages = [
      'member_id.required' => '请您选择代理商',
      'type.required'      => '请您选择类型',
      'category.required'  => '请您选择出库类型',
      'total.required'     => '请您输入出库数量',
      'operator.required'  => '请您输入操作人',
    ];

    $rule = [
      'member_id' => 'required',
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
        $model->member_id       = $request->member_id;
        $model->type            = $request->type;
        $model->category        = $request->category;
        $model->total           = $request->total;
        $model->operator        = $request->operator;
        $model->active          = 1;
        $model->save();

        $resource = Resource::firstOrNew(['outbound_id' => $model->id]);

        $resource->device_code = $request->device_code ?? '';
        $resource->picture     = $request->picture ?? '';
        $resource->save();

        $data = file_get_contents($request->device_code);

        $url = File::file_base64($data, 'equipment');
        $url = str_replace('storage', '/storage/app/public', $url);
        $url = base_path(trim($url, '/'));

        // 导入设备数据
        Excel::import(new EquipmentImport($model->id, $request->member_id), $url);

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
   * 操作信息
   * ------------------------------------------
   *
   * 操作信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function second_step(Request $request)
  {
    $messages = [
      'id.required'           => '请您输入出库单编号',
      'company_id.required'   => '请您选择物流公司',
      'logistics_no.required' => '请您输入物流编号',
    ];

    $rule = [
      'id'           => 'required',
      'company_id'   => 'required',
      'logistics_no' => 'required',
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

        $model->active = 2;
        $model->save();

        $logistics = Logistics::firstOrNew(['outbound_id' => $request->id]);

        $logistics->company_id   = $request->company_id ?? '';
        $logistics->logistics_no = $request->logistics_no ?? '';
        $logistics->save();

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
   * 操作信息
   * ------------------------------------------
   *
   * 操作信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function third_step(Request $request)
  {
    $messages = [
      'id.required' => '请您输入出库单编号',
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

        $resource = Resource::firstOrNew(['outbound_id' => $model->id]);

        $resource->receipt_form = $request->receipt_form ?? '';
        $resource->save();

        // 自动绑定设备
        event(new BindEvent($request->id));

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
