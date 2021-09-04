<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Http\Constant\Code;
use App\Models\Api\System\Config;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-13
 *
 * 会员邀请控制器类
 */
class InvitationController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\Invitation';

  // 关联对像
  protected $_relevance = [
    'list' => [
      'member',
      'invitation'
    ],
    'select' => [
      'member',
      'invitation'
    ]
  ];


  /**
   * @api {get} /api/member/invitation/list?page={page} 01. 会员邀请列表
   * @apiDescription 获取当前会员邀请分页列表
   * @apiGroup 23. 会员邀请模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|基础) {Number} id 会员邀请编号
   * @apiSuccess (字段说明|基础) {Number} member_id 会员编号
   * @apiSuccess (字段说明|基础) {Number} invitation_member_id 邀请会员编号
   * @apiSuccess (字段说明|基础) {Number} create_time 邀请时间
   * @apiSuccess (字段说明|邀请人) {Number} avatar 头像
   * @apiSuccess (字段说明|邀请人) {Number} nickname 昵称
   * @apiSuccess (字段说明|被邀请人) {Number} avatar 头像
   * @apiSuccess (字段说明|被邀请人) {Number} nickname 昵称
   *
   * @apiSampleRequest /api/member/invitation/list
   * @apiVersion 1.0.0
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getCurrentWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'list');

      $response = $this->_model::getPaging($condition, $relevance, $this->_order);

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @api {post} /api/member/invitation/data 02. 邀请人数据
   * @apiDescription 获取当前用户邀请数据
   * @apiGroup 23. 会员邀请模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {String} invitation_code 邀请码
   * @apiSuccess (字段说明) {String} invitation_content 邀请说明
   * @apiSuccess (字段说明) {String} qrcode 二维码图片
   *
   * @apiSampleRequest /api/member/invitation/data
   * @apiVersion 1.0.0
   */
  public function data(Request $request)
  {
    try
    {
      $where = ['category_id' => 3];

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($this->_where, $filter, $where);

      $response = Config::getPluck(['value', 'title'], $condition);

      $member_id = self::getCurrentId();

      $invitation_code = 'BMW' . str_pad($member_id, 6, 0, STR_PAD_LEFT);

      $response['invitation_code'] = $invitation_code;

      $filename = md5(time() . rand(1, 9999999)). '.png';

      $uri = storage_path('app/public/qrcode/' . $filename);

      $web_url = Config::getConfigValue('web_url');

      $url = $web_url . '/storage/qrcode/' . $filename;

      $params = $invitation_code;

      // 生成带有邀请人信息的二维码
      QrCode::format('png')->size(300)->encoding('UTF-8')->generate($params, $uri);

      $response['qrcode'] = $url;

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @api {post} /api/member/invitation/status 03. 是否邀请会员
   * @apiDescription 获取当前会员邀请的详情
   * @apiGroup 23. 会员邀请模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {Number} invitation_member_id 邀请会员编号
   *
   * @apiSuccess (字段说明) {Boolean} status 是否邀请
   *
   * @apiSampleRequest /api/member/invitation/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    $messages = [
      'invitation_member_id.required' => '请您输入邀请会员编号',
    ];

    $rule = [
      'invitation_member_id' => 'required',
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
        $status = true;

        $condition = self::getCurrentWhereData();

        $where = ['invitation_member_id' => $request->invitation_member_id];

        $condition = array_merge($condition, $where);

        $response = $this->_model::getRow($condition);

        if(empty($response->id))
        {
          $status = false;
        }

        return self::success($status);
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
   * @api {post} /api/member/invitation/handle 04. 邀请操作
   * @apiDescription 当前会员执行邀请操作, 已经邀请过，再次点击取消邀请
   * @apiGroup 23. 会员邀请模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} invitation_member_id 邀请人编号
   *
   * @apiSampleRequest /api/member/invitation/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'invitation_member_id.required' => '请您输入邀请人编号',
    ];

    $rule = [
      'invitation_member_id' => 'required',
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
        $this->_model::createOrDelete([
          'member_id'            => self::getCurrentId(),
          'invitation_member_id' => $request->invitation_member_id
        ]);

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
