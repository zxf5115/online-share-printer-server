<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Constant\Code;
use App\Models\Platform\System\User;
use App\Events\Platform\UserActionLogEvent;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-07
 *
 * 登录控制器
 */
class LoginController extends BaseController
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-19
   * ------------------------------------------
   * 登录
   * ------------------------------------------
   *
   * 登录
   *
   * @param integer $code 错误代码
   * @return 错误信息
   */
  public function login(Request $request)
  {
    if($request->isMethod('post'))
    {
      $messages = [
        'username.required'  => '请输入用户名称',
        'password.required'  => '请输入用户密码',
      ];

      $rule = [
        'username' => 'required',
        'password' => 'required',
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
          $username = $request['username'];
          $password = $request['password'];

          $response = User::getRow(['username' => $username]);

          // 用户不存在
          if(is_null($response))
          {
            return self::error(Code::USER_EXIST);
          }

          // 在特定时间内访问次数过多，就触发访问限制
          if(User::AccessRestrictions($response))
          {
            return self::error(Code::ACCESS_RESTRICTIONS);
          }

          // 检验用户输入的密码是否正确
          if(User::checkPassword($response, $password))
          {
            // 设置密码尝试信息
            User::setTryNumber($response);

            return self::error(Code::PASSWORD_ERROR);
          }

          $credentials = [
            'username' => $username,
            'password' => $password,
          ];

          // 认证用户密码是否可以登录
          if (! $token = auth('platform')->attempt($credentials))
          {
            return self::error(Code::USER_EXIST);
          }

          // 记录登录信息
          User::login($response, $request);

          // 记录用户行为日志
          event(new UserActionLogEvent($response, $request));

          return self::success([
            'code' => 200,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('platform')->factory()->getTTL() * 60,
            'user_info' => auth('platform')->user()
          ]);
        }
        catch(\Exception $e)
        {
          // 记录异常信息
          self::record($e);

          return self::error(Code::ERROR);
        }
      }
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-15
   * ------------------------------------------
   * 检测用户是否已经登录
   * ------------------------------------------
   *
   * 检测用户是否已经登录
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function check_user_login(Request $request)
  {
    try
    {
      // 判断当前token是否有效
      if(auth('platform')->parser()->setRequest($request)->hasToken())
      {
        return self::success();
      }
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-15
   * ------------------------------------------
   * 注册账号
   * ------------------------------------------
   *
   * 注册账号
   *
   * @param Request $request 请求数据
   * @return [type]
   */
  protected function register(Request $request)
  {
    $messages = [
      'username.required' => '请输入用户名称',
      'password.required' => '请输入用户密码',
      'nickname.required' => '请输入用户昵称',
      'mobile.required'   => '请输入用户昵称',
    ];

    $rule = [
      'username' => 'required',
      'password' => 'required',
      'nickname' => 'required',
      'mobile'   => 'required',
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
        $model = new User();

        $model->organization_id = self::getOrganizationId();
        $model->username    = $request->username;
        $model->password    = User::generate($request->password);
        $model->nickname    = $request->nickname;
        $model->mobile      = $request->mobile;

        $response = $model->save();

        if($response)
        {
          return self::success(Code::message(Code::HANDLE_SUCCESS));
        }
        else
        {
          return self::error(Code::HANDLE_FAILURE);
        }
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::ERROR);
      }
    }
  }




  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-15
   * ------------------------------------------
   * 退出系统
   * ------------------------------------------
   *
   * 退出系统
   *
   * @return [type]
   */
  public function logout(Request $request)
  {
    try
    {
      $username = auth('platform')->user();

      // 记录用户行为日志
      event(new UserActionLogEvent($username, $request));

      auth('platform')->logout();

      return self::success(Code::message(Code::LOGOUT_SUCCESS));
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-15
   * ------------------------------------------
   * 获取登录用户信息
   * ------------------------------------------
   *
   * 获取登录用户信息
   *
   * @return token信息
   */
  public function me()
  {
    try
    {
      return self::success(auth('platform')->user());
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-15
   * ------------------------------------------
   * 刷新token信息
   * ------------------------------------------
   *
   * 刷新token信息
   *
   * @return token信息
   */
  public function refresh()
  {
    try
    {
      return $this->respondWithToken(auth('platform')->refresh());
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-15
   * ------------------------------------------
   * 组装token信息
   * ------------------------------------------
   *
   * 组装token信息
   *
   * @param string $token token
   * @return token数组信息
   */
  protected function respondWithToken($token)
  {
    try
    {
      return response()->json([
        'token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('platform')->factory()->getTTL() * 60
      ]);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
