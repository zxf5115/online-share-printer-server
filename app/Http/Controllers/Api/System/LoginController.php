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
   * @api {post} /api/weixin_login 01. 微信登录
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
   * @api {post} /api/register 02. 用户注册
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
