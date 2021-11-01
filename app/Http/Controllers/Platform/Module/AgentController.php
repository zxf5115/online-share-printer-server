<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Constant\Parameter;
use App\Models\Platform\Module\Printer;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-17
 *
 * 代理人控制器类
 */
class AgentController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Agent';

  // 默认查询条件
  protected $_where = [
    'role_id' => 3
  ];

  // 客户端搜索字段
  protected $_params = [
    'level',
    'parent_id',
    'username',
    'nickname'
  ];


  // 附加关联查询条件
  protected $_addition = [
    'archive' => [
      'province_id'
    ]
  ];


  // 关联对象
  protected $_relevance = [
    'list' => [
      'parent',
      'asset',
      'archive',
    ],
    'view' => [
      'asset',
      'archive',
    ],
    'select' => false,
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 操作会员
   * ------------------------------------------
   *
   * 操作会员信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function handle(Request $request)
  {
    $messages = [
      'username.required' => '请您输入代理商电话',
      'username.regex'    => '代理商电话格式错误',
      'nickname.required' => '请您输入用户昵称',
    ];

    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',
      'nickname' => 'required',
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
        $result = $this->_model::getParentAgentId($request->level, $request->parent_username);

        if(empty($result['status']))
        {
          return self::error($result['code']);
        }

        $parent_id = $result['code'];

        $status = $this->_model::isExistField($request->username, $request->id);

        if($status)
        {
          return self::error(Code::AGENT_EXITS);
        }

        $model = $this->_model::firstOrNew(['id' => $request->id]);

        if(empty($request->id))
        {
          $model->password = $this->_model::generate(Parameter::PASSWORD);
        }

        $model->level        = $request->level ?? 0;
        $model->another_name = $request->another_name ?: $this->_model::getLevelName($request->level);
        $model->role_id      = 3;
        $model->parent_id    = $parent_id ?? 0;
        $model->username     = $request->username;
        $model->nickname     = $request->nickname;
        $model->save();

        $archive = $model->archive()->firstOrNew(['member_id' => $model->id]);

        $archive->province_id = $request->province_id ?? 0;
        $archive->city_id     = $request->city_id ?? 0;
        $archive->region_id   = $request->region_id ?? 0;
        $archive->address     = $request->address ?? '';
        $archive->save();

        $asset = $model->asset()->firstOrNew(['member_id' => $model->id]);

        $asset->should_printer_total = $request->should_printer_total ?? 0;
        $asset->proportion           = $request->proportion ?? 0.00;
        $asset->save();

        $resource = $model->resource()->firstOrNew(['member_id' => $model->id]);

        $resource->business_license = $request->business_license ?? '';
        $resource->contract         = $request->contract ?? '';
        $resource->save();

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 操作信息
   * ------------------------------------------
   *
   * 操作信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function facility(Request $request)
  {
    $messages = [
      'id.required'  => '请您输入会员编号',
      'printer_id.required' => '请您输入打印机编号',
    ];

    $rule = [
      'id'  => 'required',
      'printer_id' => 'required',
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

        $printer = self::packRelevanceData($request, 'printer_id');

        if(!empty($printer))
        {
          $model->printer()->update(['allot_status' => 2]);
          $model->memberPrinter()->delete();
          $model->memberPrinter()->createMany($printer);
        }

        // 将库存设备标记为已分配
        foreach($printer as $item)
        {
          Printer::where(['id' => $item['printer_id']])->update(['allot_status' => 1]);
        }

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
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 初始化密码
   * ------------------------------------------
   *
   * 初始化密码
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function password(Request $request)
  {
    try
    {
      $password = $this->_model::generate(Parameter::PASSWORD);

      $model = $this->_model::find($request->id);
      $model->password = $password;
      $model->save();

      return self::success(Code::message(Code::HANDLE_SUCCESS));
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::HANDLE_FAILURE);
    }
  }
}
