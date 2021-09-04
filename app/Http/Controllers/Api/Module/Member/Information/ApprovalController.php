<?php
namespace App\Http\Controllers\Api\Module\Member\Information;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Models\Api\Module\Information;
use App\Events\Common\Push\AuroraEvent;
use App\Http\Controllers\Api\BaseController;
use App\Events\Api\Member\Information\ApprovalEvent;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员点赞控制器类
 */
class ApprovalController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Information\Approval';

  // 关联对像
  protected $_relevance = [
    'list' => [
      'information',
      'member',
    ]
  ];


  /**
   * @api {get} /api/member/information/approval/list?page={page} 01. 会员点赞列表
   * @apiDescription 获取当前会员点赞分页列表
   * @apiGroup 63. 资讯点赞模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|资讯) {String} id 资讯编号
   * @apiSuccess (字段说明|资讯) {String} title 资讯标题
   * @apiSuccess (字段说明|资讯) {String} picture 资讯封面
   * @apiSuccess (字段说明|资讯) {String} content 资讯内容
   * @apiSuccess (字段说明|资讯) {String} source 资讯来源
   * @apiSuccess (字段说明|资讯) {String} author 资讯作者
   * @apiSuccess (字段说明|资讯) {String} read_total 阅读总数
   * @apiSuccess (字段说明|资讯) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明|资讯) {String} create_time 发布时间
   * @apiSuccess (字段说明|会员) {Number} avatar 会员头像
   * @apiSuccess (字段说明|会员) {Number} nickname 会员昵称
   *
   * @apiSampleRequest /api/member/information/approval/list
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
   * @api {post} /api/member/information/approval/status 02. 资讯是否点赞
   * @apiDescription 获取当前会员点赞的详情
   * @apiGroup 63. 资讯点赞模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (basic params) {Number} information_id 资讯编号
   *
   * @apiSampleRequest /api/member/information/approval/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    $messages = [
      'information_id.required' => '请您输入资讯编号',
    ];

    $rule = [
      'information_id' => 'required',
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

        $where = ['information_id' => $request->information_id];

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
   * @api {post} /api/member/information/approval/handle 03. 点赞操作
   * @apiDescription 当前会员执行资讯点赞操作, 已经点赞过，再次点击取消点赞
   * @apiGroup 63. 资讯点赞模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} information_id 资讯编号
   *
   * @apiSampleRequest /api/member/information/approval/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'information_id.required' => '请您输入资讯编号',
    ];

    $rule = [
      'information_id' => 'required',
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
        $status = $this->_model::createOrDelete([
          'member_id' => self::getCurrentId(),
          'information_id' => $request->information_id
        ]);

        // 记录点赞资讯总数
        event(new ApprovalEvent($status, $request->information_id));

        // 资讯数据
        $information = Information::getRow(['id' => $request->information_id]);

        if(!empty($information->id))
        {
          $nickname = self::getCurrentNickname();

          $data = $status ? '点赞' : '取消点赞';

          $content = $nickname . $data . '了您的' .$information->title;

          $data = [
            'title'     => '资讯点赞消息',
            'content'   => $content,
          ];

          // 消息推送
          event(new AuroraEvent(1, $data, $information->member_id));
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
}
