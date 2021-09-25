<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Constant\Parameter;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-17
 *
 * 店长控制器类
 */
class ManagerController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Manager';

  // 默认查询条件
  protected $_where = [
    'role_id' => 2
  ];

  // 客户端搜索字段
  protected $_params = [
    'role_id',
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
      'archive',
      'asset'
    ],
    'select' => false
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
      'username.required' => '请您输入登录账户',
      'username.regex'    => '登录账户格式错误',
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
      try
      {
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        if(empty($request->id))
        {
          $model->password = $this->_model::generate(Parameter::PASSWORD);
        }

        $model->username     = $request->username;
        $model->nickname     = $request->nickname;
        $model->avatar       = $request->avatar ?: '';
        $model->audit_status = $request->audit_status ?? 1;
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
