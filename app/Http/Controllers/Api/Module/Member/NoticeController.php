<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员通知接口控制器类
 */
class NoticeController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\MemberNotice';

  // 附加搜索条件
  protected $_addition = [
    'notice' => [
      'category_id'
    ]
  ];


  /**
   * @api {get} /api/member/notice/list?page={page} 我的通知列表
   * @apiDescription 获取当前会员通知分页列表
   * @apiGroup 24. 会员通知模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} message_category_id 通知分类编号
   *
   * @apiSuccess (字段说明) {String} id 会员通知编号
   * @apiSuccess (字段说明) {String} content 通知内容
   * @apiSuccess (字段说明) {String} create_time 通知时间
   *
   * @apiSampleRequest /api/member/notice/list
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

      // 关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'list');

      $response = $this->_model::getPaging($condition, $relevance, $this->_order);

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @api {post} /api/member/notice/finish 我的通知已阅读
   * @apiDescription 当前会员通知标记已阅读
   * @apiGroup 24. 会员通知模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} message_id 会员通知编号
   *
   * @apiSampleRequest /api/member/notice/finish
   * @apiVersion 1.0.0
   */
  public function finish(Request $request)
  {
    try
    {
      $condition = self::getCurrentWhereData();

      $where = [
        'id' => $request->message_id
      ];

      $condition = array_merge($condition, $where);

      // 设置为已读
      $model = $this->_model::getRow($condition);
      $model->is_finish = 1;
      $model->save();

      return self::success(Code::message(Code::HANDLE_SUCCESS));
    }
    catch(\Exception $e)
    {
      record($e);

      return self::error(Code::ERROR);
    }
  }
}
