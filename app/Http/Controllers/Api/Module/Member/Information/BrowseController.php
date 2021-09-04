<?php
namespace App\Http\Controllers\Api\Module\Member\Information;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯控制器类
 */
class BrowseController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Information\Browse';


  // 关联对象
  protected $_relevance = [
    'list' => [
      'information'
    ]
  ];

  /**
   * @api {get} /api/member/information/browse/list?page={page} 01. 我的浏览历史列表
   * @apiDescription 获取我的浏览历史分页列表
   * @apiGroup 66. 资讯浏览历史模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|资讯) {Number} id 资讯编号
   * @apiSuccess (字段说明|资讯) {String} title 资讯标题
   * @apiSuccess (字段说明|资讯) {String} picture 资讯封面
   * @apiSuccess (字段说明|资讯) {String} content 资讯内容
   * @apiSuccess (字段说明|资讯) {String} source 资讯来源
   * @apiSuccess (字段说明|资讯) {String} author 资讯作者
   * @apiSuccess (字段说明|资讯) {String} read_total 阅读总数
   * @apiSuccess (字段说明|资讯) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明|资讯) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/member/information/browse/list
   * @apiVersion 1.0.0
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getCurrentWhereData('member_id');

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
   * @api {post} /api/member/information/browse/clear 02. 清除浏览历史
   * @apiDescription 当前会员清除浏览历史
   * @apiGroup 66. 资讯浏览历史模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSampleRequest /api/member/information/browse/clear
   * @apiVersion 1.0.0
   */
  public function clear(Request $request)
  {
    try
    {
      $member_id = self::getCurrentId();

      $this->_model::where(['member_id' => $member_id])->delete();

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
