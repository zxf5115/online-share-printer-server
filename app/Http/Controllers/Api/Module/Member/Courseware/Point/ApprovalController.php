<?php
namespace App\Http\Controllers\Api\Module\Member\Courseware\Point;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;
use App\Events\Api\Member\Courseware\Point\ApprovalEvent;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-26
 *
 * 会员点赞控制器类
 */
class ApprovalController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Education\Courseware\Point\Approval';

  // 关联对像
  protected $_relevance = [
    'list' => [
      'point',
      'member',
    ]
  ];


  /**
   * @api {get} /api/member/courseware/point/approval/list?page={page} 01. 会员知识点点赞列表
   * @apiDescription 获取当前会员知识点点赞分页列表
   * @apiGroup 44. 课程知识点点赞模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|课程知识点) {Number} id 课程知识点编号
   * @apiSuccess (字段说明|课程知识点) {Number} courseware_id 课程编号
   * @apiSuccess (字段说明|课程知识点) {String} title 课程知识点名称
   * @apiSuccess (字段说明|课程知识点) {String} picture 课程知识点封面
   * @apiSuccess (字段说明|课程知识点) {Number} url 课程知识点视频
   * @apiSuccess (字段说明|课程知识点) {Number} approval_total 点赞总数
   * @apiSuccess (字段说明|课程知识点) {Number} create_time 发布时间
   * @apiSuccess (字段说明|会员) {Number} avatar 会员头像
   * @apiSuccess (字段说明|会员) {Number} nickname 会员昵称
   *
   * @apiSampleRequest /api/member/courseware/point/approval/list
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
   * @api {post} /api/member/courseware/point/approval/status 02. 知识点是否点赞
   * @apiDescription 获取当前会员知识点是否点赞
   * @apiGroup 44. 课程知识点点赞模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (basic params) {Number} point_id 知识点编号
   *
   * @apiSampleRequest /api/member/courseware/point/approval/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    $messages = [
      'point_id.required' => '请您输入知识点编号',
    ];

    $rule = [
      'point_id' => 'required',
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

        $where = ['point_id' => $request->point_id];

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
   * @api {post} /api/member/courseware/point/approval/handle 03. 点赞操作
   * @apiDescription 当前会员知识点执行社区点赞操作, 已经点赞过，再次点击取消点赞
   * @apiGroup 44. 课程知识点点赞模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} point_id 知识点编号
   *
   * @apiSampleRequest /api/member/courseware/point/approval/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'point_id.required' => '请您输入知识点编号',
    ];

    $rule = [
      'point_id' => 'required',
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
          'point_id' => $request->point_id
        ]);

        // 记录知识点点赞总数
        event(new ApprovalEvent($status, $request->point_id));

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
