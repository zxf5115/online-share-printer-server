<?php
namespace App\Http\Controllers\Api\System;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Http\Constant\Code;
use App\TraitClass\ToolTrait;
use App\Http\Constant\RedisKey;
use App\Http\Constant\Parameter;
use App\Models\Api\Module\Member;
use App\Events\Common\Sms\CodeEvent;
use App\Events\Common\Message\SmsEvent;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-09
 *
 * 登录控制器
 */
class LoginController extends BaseController
{
  /**
   * @api {post} /api/login 01. 密码登录
   * @apiDescription 通过账户密码进行登录操作
   * @apiGroup 01. 登录模块
   *
   * @apiParam {string} username 登录账户（18201018926）
   * @apiParam {string} password 登录密码（123456）
   *
   * @apiSuccess (字段说明|令牌) {String} token 身份令牌
   * @apiSuccess (字段说明|用户) {Number} id 会员编号
   * @apiSuccess (字段说明|用户) {Number} role_id 角色编号
   * @apiSuccess (字段说明|用户) {Number} open_id 微信编号
   * @apiSuccess (字段说明|用户) {Number} apply_id 苹果编号
   * @apiSuccess (字段说明|用户) {Number} inviter_id 邀请人编号
   * @apiSuccess (字段说明|用户) {Number} member_no 会员号
   * @apiSuccess (字段说明|用户) {String} avatar 会员头像
   * @apiSuccess (字段说明|用户) {String} username 登录账户
   * @apiSuccess (字段说明|用户) {String} nickname 会员昵称
   * @apiSuccess (字段说明|角色) {String} id 角色编号
   * @apiSuccess (字段说明|角色) {String} title 角色名称
   * @apiSuccess (字段说明|角色) {String} content 角色描述
   * @apiSuccess (字段说明|贵宾) {String} title 贵宾标题
   *
   * @apiSampleRequest /api/login
   * @apiVersion 1.0.0
   */
  public function login(Request $request)
  {
    $messages = [
      'username.required'  => '请输入用户名称',
      'username.regex'     => '手机号码不合法',
      'password.required'  => '请输入用户密码',
    ];

    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',     //正则验证
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
        $username = $request->username;
        $password = $request->password;

        $condition = self::getSimpleWhereData($username, 'username');

        $response = Member::getRow($condition, ['role', 'vipRelevance.gvip']);

        // 用户不存在
        if(is_null($response))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 用户已禁用
        if(2 == $response->status['value'])
        {
          return self::error(Code::MEMBER_DISABLE);
        }

        // 在特定时间内访问次数过多，就触发访问限制
        if(Member::AccessRestrictions($response))
        {
          return self::error(Code::ACCESS_RESTRICTIONS);
        }

        // 检验用户输入的密码是否正确
        if(Member::checkPassword($response, $password))
        {
          // 设置密码尝试信息
          Member::setTryNumber($response);

          return self::error(Code::PASSWORD_ERROR);
        }

        $credentials = [
          'username' => $username,
          'password' => $password,
        ];

        // 认证用户密码是否可以登录
        if (! $token = auth('api')->attempt($credentials))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 获取客户端ip地址
        $response->last_login_ip = $request->getClientIp();

        $old_token = $response->remember_token;

        if(!empty($old_token))
        {
          \JWTAuth::setToken($old_token)->invalidate();
        }

        // 记录登录信息
        Member::login($response, $request);

        return self::success([
          'code' => 200,
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth('api')->factory()->getTTL() * 60,
          'user_info' => $response
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


  /**
   * @api {post} /api/oauth_login 02. 一键登录
   * @apiDescription 短信登录
   * @apiGroup 01. 登录模块
   * @apiParam {string} login_token 登录令牌
   *
   * @apiSuccess (字段说明|令牌) {String} token 身份令牌
   * @apiSuccess (字段说明|用户) {Number} id 会员编号
   * @apiSuccess (字段说明|用户) {Number} role_id 角色编号
   * @apiSuccess (字段说明|用户) {Number} open_id 微信编号
   * @apiSuccess (字段说明|用户) {Number} apply_id 苹果编号
   * @apiSuccess (字段说明|用户) {Number} inviter_id 邀请人编号
   * @apiSuccess (字段说明|用户) {Number} member_no 会员号
   * @apiSuccess (字段说明|用户) {String} avatar 会员头像
   * @apiSuccess (字段说明|用户) {String} username 登录账户
   * @apiSuccess (字段说明|用户) {String} nickname 会员昵称
   * @apiSuccess (字段说明|角色) {String} id 角色编号
   * @apiSuccess (字段说明|角色) {String} title 角色名称
   * @apiSuccess (字段说明|角色) {String} content 角色描述
   * @apiSuccess (字段说明|贵宾) {String} title 贵宾标题
   *
   * @apiSampleRequest /api/oauth_login
   * @apiVersion 1.0.0
   */
  public function oauth_login(Request $request)
  {
    $messages = [
      'login_token.required' => '请输入登录令牌',
    ];

    $rule = [
      'login_token' => 'required',
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
        $url    = getenv('JG_OAUTH_URL');

        $key = getenv('JPUSH_APP_KEY');
        $secret = getenv('JPUSH_APP_MASTER_SECRET');

        $login_token = $request->login_token;

        $data = json_encode(['loginToken' => $login_token]);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, "$key:$secret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);

        if(false === $result = curl_exec($ch))
        {
          return self::error(Code::ERROR);
        }

        curl_close($ch);

        $result = json_decode($result, true);

        if(empty($result['phone']))
        {
          return self::error(Code::ERROR);
        }

        $encrypted = $result['phone'];

        $key = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBALZKEnH84lVa6zCy
vrv8uncCibvZ39ALdHLm9hWB58jEbYU8mRsTkms+4hygAgZzU8T5c3Jq3w1TFwwq
nT0R6UT9uth6oMGCudK4cZ9CzH37TVmfq79FG5Y4IpuEa7QoVeKkLPHfZvmU0Ads
ph8a36iFKuUp9RSWtM9Otni2OgW/AgMBAAECgYEAiahoQ4JYHWMaZt0k4muZGJRn
FOAUf1SXLMozncxLEDceCdbYPDVMhgan1DwVK2/eG8rRHt+L79EGf56SvXKQN82f
0PMUBj0us7lpImScpfbjyAkYANqnfnzuumBrktlW9tAFTHR3G7lrkBBMX4ZAsHpO
sNgvJkwCrWBaRlLPfrkCQQDk3wq5BpRwSy1XciSxHLA2EPfAQYcvFLs+iRkVP+AP
WqeiYh7kL3WpAsYaSxV5Lw1ExdlaoLglBaVO1kN3oi31AkEAy+WH0Tqest4fWCtB
iWO7URnFvz2kMkSHOjsbXkhhU70R475ln0kUp41gIXoXCoM+Xw6uwnRvLGbb0Iw8
mtFAYwJAc/TdRekjg9FS458dH+7dCEeIfou0phHm3EQxxSZbquvPSuJTrGCvSDXz
kJbCBmfkXRewi84p/ffiTRMZk59DkQJAHhQqSQ9gwfpKnXMkI+R2iaxHo8KwKko5
uLlnfC0pTnUh4nr/+tOJHH6ao9Wi+IYL+XHtDfqnO+Ggo89MUXp1CQJAVQFXIsnG
XZBWlZNYS1MYhK1dLwMRIz+op+XrORpxu3+piNHUw+VcQB2/sARKSDINfAgQg2Z/
BCJ1DmmcAMkT1w==
-----END PRIVATE KEY-----';

        openssl_private_decrypt(base64_decode($encrypted), $username, openssl_pkey_get_private($key));

        $condition = self::getSimpleWhereData($username, 'username');

        $response = Member::getRow($condition, ['role', 'vipRelevance.gvip']);

        // 用户不存在, 自动注册
        if(is_null($response))
        {
          Member::register('username', $username);

          $response = Member::getRow($condition, ['role', 'vipRelevance.gvip']);
        }

        // 用户已禁用
        if(2 == $response->status['value'])
        {
          return self::error(Code::MEMBER_DISABLE);
        }

        // 在特定时间内访问次数过多，就触发访问限制
        if(Member::AccessRestrictions($response))
        {
          return self::error(Code::ACCESS_RESTRICTIONS);
        }

        // 认证用户密码是否可以登录
        if (! $token = auth('api')->tokenById($response->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 获取客户端ip地址
        $response->last_login_ip = $request->getClientIp();

        $old_token = $response->remember_token;

        if(!empty($old_token))
        {
          \JWTAuth::setToken($old_token)->invalidate();
        }

        // 记录登录信息
        Member::login($response, $request);

        return self::success([
          'code' => 200,
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth('api')->factory()->getTTL() * 60,
          'user_info' => $response
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



  /**
   * @api {post} /api/sms_login 03. 短信登录
   * @apiDescription 短信登录
   * @apiGroup 01. 登录模块
   * @apiParam {string} username 登录账户（18201018926）
   * @apiParam {string} sms_code 短信验证码（7777）
   *
   * @apiSuccess (字段说明|令牌) {String} token 身份令牌
   * @apiSuccess (字段说明|用户) {Number} id 会员编号
   * @apiSuccess (字段说明|用户) {Number} role_id 角色编号
   * @apiSuccess (字段说明|用户) {Number} open_id 微信编号
   * @apiSuccess (字段说明|用户) {Number} apply_id 苹果编号
   * @apiSuccess (字段说明|用户) {Number} inviter_id 邀请人编号
   * @apiSuccess (字段说明|用户) {Number} member_no 会员号
   * @apiSuccess (字段说明|用户) {String} avatar 会员头像
   * @apiSuccess (字段说明|用户) {String} username 登录账户
   * @apiSuccess (字段说明|用户) {String} nickname 会员昵称
   * @apiSuccess (字段说明|角色) {String} id 角色编号
   * @apiSuccess (字段说明|角色) {String} title 角色名称
   * @apiSuccess (字段说明|角色) {String} content 角色描述
   * @apiSuccess (字段说明|贵宾) {String} title 贵宾标题
   *
   * @apiSampleRequest /api/sms_login
   * @apiVersion 1.0.0
   */
  public function sms_login(Request $request)
  {
    $messages = [
      'username.required' => '请输入用户名称',
      'username.regex'    => '手机号码不合法',
      'sms_code.required' => '请输入短信验证码',
    ];

    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',     //正则验证
      'sms_code' => 'required',
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
        $username = $request->username;

        $sms_code = $request->sms_code;

        // 比对验证码
        $status = event(new CodeEvent($username, $sms_code));

        // 验证码错误
        if(empty($status))
        {
          // return self::error(Code::VERIFICATION_CODE);
        }

        $condition = self::getSimpleWhereData($username, 'username');

        $response = Member::getRow($condition, ['role', 'vipRelevance.gvip']);

        // 用户不存在, 自动注册
        if(is_null($response))
        {
          Member::register('username', $username);

          $response = Member::getRow($condition, ['role', 'vipRelevance.gvip']);
        }

        // 用户已禁用
        if(2 == $response->status['value'])
        {
          return self::error(Code::MEMBER_DISABLE);
        }

        // 在特定时间内访问次数过多，就触发访问限制
        if(Member::AccessRestrictions($response))
        {
          return self::error(Code::ACCESS_RESTRICTIONS);
        }

        // 认证用户密码是否可以登录
        if (! $token = auth('api')->tokenById($response->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 获取客户端ip地址
        $response->last_login_ip = $request->getClientIp();

        $old_token = $response->remember_token;

        if(!empty($old_token))
        {
          \JWTAuth::setToken($old_token)->invalidate();
        }

        // 记录登录信息
        Member::login($response, $request);

        return self::success([
          'code' => 200,
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth('api')->factory()->getTTL() * 60,
          'user_info' => $response
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


  /**
   * @api {post} /api/sms_code 04. 登录验证码
   * @apiDescription 获取短信登录验证码
   * @apiGroup 01. 登录模块
   * @apiParam {string} username 登录账户（18201018926）
   *
   * @apiSampleRequest /api/sms_code
   * @apiVersion 1.0.0
   */
  public function sms_code(Request $request)
  {
    $messages = [
      'username.required'  => '请输入用户名称',
      'username.regex'     => '手机号码不合法',
    ];

    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',     //正则验证
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
        $username = $request->username;

        // $condition = self::getSimpleWhereData($username, 'username');

        // $response = Member::getRow($condition);

        // if(empty($response))
        // {
        //   return self::error(Code::MEMBER_EMPTY);
        // }

        // 发送登录验证码
        event(new SmsEvent($username, 1));

        return self::success(Code::message(Code::SEND_SUCCESS));
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
   * @api {post} /api/weixin_login 05. 微信登录
   * @apiDescription 通过第三方软件-微信，进行登录
   * @apiGroup 01. 登录模块
   * @apiParam {string} open_id 微信OpenID
   *
   * @apiSuccess (字段说明|令牌) {String} token 身份令牌
   * @apiSuccess (字段说明|用户) {Number} id 会员编号
   * @apiSuccess (字段说明|用户) {Number} role_id 角色编号
   * @apiSuccess (字段说明|用户) {Number} open_id 微信编号
   * @apiSuccess (字段说明|用户) {Number} apply_id 苹果编号
   * @apiSuccess (字段说明|用户) {Number} inviter_id 邀请人编号
   * @apiSuccess (字段说明|用户) {Number} member_no 会员号
   * @apiSuccess (字段说明|用户) {String} avatar 会员头像
   * @apiSuccess (字段说明|用户) {String} username 登录账户
   * @apiSuccess (字段说明|用户) {String} nickname 会员昵称
   * @apiSuccess (字段说明|角色) {String} id 角色编号
   * @apiSuccess (字段说明|角色) {String} title 角色名称
   * @apiSuccess (字段说明|角色) {String} content 角色描述
   * @apiSuccess (字段说明|贵宾) {String} title 贵宾标题
   *
   * @apiSampleRequest /api/weixin_login
   * @apiVersion 1.0.0
   */
  public function weixin_login(Request $request)
  {
    $messages = [
      'open_id.required' => '请输入微信编号',
    ];

    $rule = [
      'open_id' => 'required',
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
        $condition = self::getSimpleWhereData($request->open_id, 'open_id');

        $response = Member::getRow($condition, ['role', 'vipRelevance.gvip']);

        // 用户不存在
        if(is_null($response))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 用户已禁用
        if(2 == $response->status['value'])
        {
          return self::error(Code::MEMBER_DISABLE);
        }

        // 在特定时间内访问次数过多，就触发访问限制
        if(Member::AccessRestrictions($response))
        {
          return self::error(Code::ACCESS_RESTRICTIONS);
        }

        // 认证用户密码是否可以登录
        if (! $token = auth('api')->tokenById($response->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 获取客户端ip地址
        $response->last_login_ip = $request->getClientIp();

        $old_token = $response->remember_token;

        if(!empty($old_token))
        {
          \JWTAuth::setToken($old_token)->invalidate();
        }

        // 记录登录信息
        Member::login($response, $request);

        return self::success([
          'code' => 200,
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth('api')->factory()->getTTL() * 60,
          'user_info' => $response
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


  /**
   * @api {post} /api/apple_login 06. 苹果登录
   * @apiDescription 通过第三方软件-苹果，进行登录
   * @apiGroup 01. 登录模块
   * @apiParam {string} apply_id 苹果AppleID
   *
   * @apiSuccess (字段说明|令牌) {String} token 身份令牌
   * @apiSuccess (字段说明|用户) {Number} id 会员编号
   * @apiSuccess (字段说明|用户) {Number} role_id 角色编号
   * @apiSuccess (字段说明|用户) {Number} open_id 微信编号
   * @apiSuccess (字段说明|用户) {Number} apply_id 苹果编号
   * @apiSuccess (字段说明|用户) {Number} inviter_id 邀请人编号
   * @apiSuccess (字段说明|用户) {Number} member_no 会员号
   * @apiSuccess (字段说明|用户) {String} avatar 会员头像
   * @apiSuccess (字段说明|用户) {String} username 登录账户
   * @apiSuccess (字段说明|用户) {String} nickname 会员昵称
   * @apiSuccess (字段说明|角色) {String} id 角色编号
   * @apiSuccess (字段说明|角色) {String} title 角色名称
   * @apiSuccess (字段说明|角色) {String} content 角色描述
   * @apiSuccess (字段说明|贵宾) {String} title 贵宾标题
   *
   * @apiSampleRequest /api/apple_login
   * @apiVersion 1.0.0
   */
  public function apple_login(Request $request)
  {
    $messages = [
      'apply_id.required' => '请输入苹果密钥',
    ];

    $rule = [
      'apply_id' => 'required',
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
        $condition = self::getSimpleWhereData();

        $where = ['apply_id' => $request->apply_id];

        $where = array_merge($condition, $where);

        $response = Member::getRow($where, ['role', 'vipRelevance.gvip']);

        // 用户不存在
        if(is_null($response))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 用户已禁用
        if(2 == $response->status['value'])
        {
          return self::error(Code::MEMBER_DISABLE);
        }

        // 在特定时间内访问次数过多，就触发访问限制
        if(Member::AccessRestrictions($response))
        {
          return self::error(Code::ACCESS_RESTRICTIONS);
        }

        // 认证用户密码是否可以登录
        if (! $token = auth('api')->tokenById($response->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 获取客户端ip地址
        $response->last_login_ip = $request->getClientIp();

        $old_token = $response->remember_token;

        if(!empty($old_token))
        {
          \JWTAuth::setToken($old_token)->invalidate();
        }

        // 记录登录信息
        Member::login($response, $request);

        return self::success([
          'code' => 200,
          'token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth('api')->factory()->getTTL() * 60,
          'user_info' => $response
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


  /**
   * @api {post} /api/register 07. 用户注册
   * @apiDescription 注册用户信息
   * @apiGroup 01. 登录模块
   *
   * @apiParam {string} [open_id] 微信app编号
   * @apiParam {string} [apply_id] 苹果登录编号
   * @apiParam {string} username 登录手机号码
   * @apiParam {string} avatar 会员头像
   * @apiParam {string} nickname 会员姓名
   * @apiParam {string} [sex] 会员性别
   * @apiParam {string} [age] 会员性别
   * @apiParam {string} [province_id] 省
   * @apiParam {string} [city_id] 市
   * @apiParam {string} [region_id] 县
   * @apiParam {string} [address] 详细地址
   *
   * @apiSampleRequest /api/register
   * @apiVersion 1.0.0
   */
  public function register(Request $request)
  {
    $messages = [
      'username.required'    => '请您输入登录手机号码',
      'nickname.required'    => '请您输入会员姓名',
      'avatar.required'      => '请您上传会员头像',
    ];

    $rule = [
      'username'    => 'required',
      'nickname'    => 'required',
      'avatar'      => 'required',
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
        if(empty($request->open_id))
        {
          $model = Member::firstOrNew(['apply_id' => $request->apply_id, 'status' => 1]);
        }
        else
        {
          $model = Member::firstOrNew(['open_id' => $request->open_id, 'status' => 1]);
        }

        if(empty($request->id))
        {
          $model->member_no = ToolTrait::generateOnlyNumber(3);
        }

        $model->open_id  = $request->open_id ?? '';
        $model->apply_id = $request->apply_id ?? '';
        $model->role_id  = 1;
        $model->avatar   = $request->avatar;
        $model->username = $request->username;
        $model->nickname = $request->nickname;
        $model->save();

        $data = [
          'sex'         => $request->sex ?? '1',
          'age'         => $request->age ?? '1',
          'province_id' => $request->province_id ?? '',
          'city_id'     => $request->city_id ?? '',
          'region_id'   => $request->region_id ?? '',
          'address'     => $request->address ?? '',
        ];

        if(!empty($data))
        {
          $model->archive()->delete();
          $model->archive()->create($data);
        }

        $data = [
          'money' => 0.00,
        ];

        if(!empty($data))
        {
          $model->asset()->delete();
          $model->asset()->create($data);
        }

        $data = [
          'push_switch'    => 1,
        ];

        if(!empty($data))
        {
          $model->setting()->delete();
          $model->setting()->create($data);
        }

        $data = [
          'vip_id'    => 1,
        ];

        if(!empty($data))
        {
          $model->vipRelevance()->delete();
          $model->vipRelevance()->create($data);
        }

        DB::commit();

        return self::success(Code::message(Code::REGISTER_SUCCESS));
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
   * @api {post} /api/bind_mobile 08. 绑定手机号码
   * @apiDescription 绑定用的的手机号码
   * @apiGroup 01. 登录模块
   *
   * @apiParam {string} open_id 微信登录编号
   * @apiParam {string} username 登录手机号码
   * @apiParam {string} sms_code 验证码
   *
   * @apiSampleRequest /api/bind_mobile
   * @apiVersion 1.0.0
   */
  public function bind_mobile(Request $request)
  {
    $messages = [
      'username.required' => '请您输入登录账户',
      'username.regex'    => '手机号码不合法',
      'sms_code.required' => '请您输入验证码',
    ];

    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',     //正则验证
      'sms_code' => 'required',
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
        $username = $request->username;

        $sms_code = $request->sms_code;

        // 比对验证码
        $status = event(new CodeEvent($username, $sms_code, 5));

        // 验证码错误
        if(empty($status))
        {
          // return self::error(Code::VERIFICATION_CODE);
        }

        $condition = self::getSimpleWhereData($username, 'username');

        $model = Member::getRow($condition);

        if(empty($model->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        if(!empty($model->open_id))
        {
          return self::error(Code::CURRENT_MOBILE_BIND);
        }

        $model->open_id = $request->open_id;

        $response = $model->save();

        return self::success(Code::$message[Code::HANDLE_SUCCESS]);
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @api {post} /api/bind_code 09. 获取绑定验证码
   * @apiDescription 获取登录手机号的绑定验证码
   * @apiGroup 01. 登录模块
   *
   * @apiParam {string} username 登录账户（18201018888）
   *
   * @apiSampleRequest /api/bind_code
   * @apiVersion 1.0.0
   */
  public function bind_code(Request $request)
  {
    $messages = [
      'username.required' => '请输入用户名称',
      'username.regex'    => '手机号码不合法',
    ];
    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',     //正则验证
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
        $username = $request->username;

        $condition = self::getSimpleWhereData($username, 'username');

        $result = Member::getRow($condition);

        if(!empty($result) && !empty($result->open_id))
        {
          return self::error(Code::CURRENT_MOBILE_BIND);
        }

        // 发送登录验证码
        event(new SmsEvent($username, 5));

        return self::success(Code::message(Code::SEND_SUCCESS));
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
   * @api {post} /api/reset_code 10. 重置验证码
   * @apiDescription 获取重置验证码
   * @apiGroup 01. 登录模块
   *
   * @apiParam {string} username 登录账户（18201018888）
   *
   * @apiSuccess (响应) {String} data 验证码
   *
   * @apiSampleRequest /api/reset_code
   * @apiVersion 1.0.0
   */
  public function reset_code(Request $request)
  {
    $messages = [
      'username.required'  => '请输入用户名称',
      'username.regex'     => '手机号码不合法',
    ];

    $rule = [
      'username' => 'required',
      'username' => 'regex:/^1[3456789][0-9]{9}$/',     //正则验证
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
        $username = $request->username;

        $condition = self::getSimpleWhereData($username, 'username');

        $response = Member::getRow($condition);

        if(empty($response->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        // 发送重置验证码
        event(new SmsEvent($username, 3));

        return self::success(Code::HANDLE_SUCCESS);
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        record($e);

        return self::error(Code::ERROR);
      }
    }
  }


  /**
   * @api {post} /api/back_mobile 11. 手机找回密码
   * @apiDescription 通过手机号码找回密码
   * @apiGroup 01. 登录模块
   *
   * @apiParam {string} username 登录手机号码
   * @apiParam {string} sms_code 验证码
   * @apiParam {string} password 新密码
   * @apiParam {string} password_confirmation 确认密码
   *
   * @apiSampleRequest /api/back_mobile
   * @apiVersion 1.0.0
   */
  public function back_mobile(Request $request)
  {
    $messages = [
      'username.required'  => '请您输入登录账户',
      'sms_code.required'  => '请您输入验证码',
      'password.required'  => '请您输入新密码',
      'password.between'   => '输入的密码必须是6-16位',
      'password.confirmed' => '您输入的两次密码信息不一致',
    ];

    $rule = [
      'username' => 'required',
      'sms_code' => 'required',
      'password' => 'required|between:6,16|confirmed',
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
        $username = $request->username;

        $sms_code = $request->sms_code;

        // 比对验证码
        $status = event(new CodeEvent($username, $sms_code, 3));

        // 验证码错误
        if(empty($status))
        {
          // return self::error(Code::VERIFICATION_CODE);
        }

        $condition = self::getSimpleWhereData($username, 'username');

        $model = Member::getRow($condition);

        if(empty($model->id))
        {
          return self::error(Code::MEMBER_EMPTY);
        }

        $password = Member::generate($request->password);

        $model->password = $password;
        $model->save();

        return self::success(Code::HANDLE_SUCCESS);
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
   * @api {get} /api/logout 12. 退出
   * @apiDescription 退出登录状态
   * @apiGroup 01. 登录模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmN"
   * }
   *
   * @apiSampleRequest /api/logout
   * @apiVersion 1.0.0
   */
  public function logout()
  {
    try
    {
      auth('api')->logout();

      return self::success([], '退出成功');
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
