<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Events\Api\Member\ExtractEvent;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-16
 *
 * 提现控制器类
 */
class WithdrawalController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Organization\Withdrawal';

  // 客户端搜索字段
  protected $_params = [
    'member_id'
  ];

  // 附加关联查询条件
  protected $_addition = [
    'organization' => [
      'username'
    ]
  ];

  // 关联对象
  protected $_relevance = [
    'organization',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-19
   * ------------------------------------------
   * 操作信息
   * ------------------------------------------
   *
   * 操作信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function handle(Request $request)
  {
    $messages = [
      'id.required' => '请您输入提现编号',
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


        // 提现
        $result = event(new ExtractEvent($model));

        if($result)
        {
          $model->withdrawal_status = 1;
          $model->audit_type = 1;
          $model->save();
        }

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        record($e);

        return self::message('提现失败');
      }
    }
  }
}
