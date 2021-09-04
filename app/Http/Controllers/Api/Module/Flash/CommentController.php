<?php
namespace App\Http\Controllers\Api\Module\Flash;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 快讯评论控制器类
 */
class CommentController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Flash\Comment';

  // 默认查询条件
  protected $_where = [
    'comment_id' => 0
  ];

  // 客户端搜索字段
  protected $_params = [
    'flash_id',
    'comment_id'
  ];

  // 关联对像
  protected $_relevance = [
    'list' => [
      'children.bemember',
      'children.member',
      'member',
    ],
    'other' => [
      'bemember',
      'member',
    ]
  ];


  /**
   * @api {get} /api/flash/comment/list?page={page} 01. 快讯评论列表
   * @apiDescription 获取快讯评论分页列表
   * @apiGroup 52. 快讯评论模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {string} flash_id 快讯编号
   *
   * @apiSuccess (字段说明|评论) {String} content 评论内容
   * @apiSuccess (字段说明|评论) {String} approval_total 点赞数量
   * @apiSuccess (字段说明|评论) {String} create_time 评论时间
   * @apiSuccess (字段说明|评论人) {String} avatar 评论人头像
   * @apiSuccess (字段说明|评论人) {String} nickname 评论人昵称
   *
   * @apiSampleRequest /api/flash/comment/list
   * @apiVersion 1.0.0
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'list');

      $response = $this->_model::getPaging($condition, $relevance, $this->_order, true);

      $response['data'] = $this->_model::getChildData($response['data']);

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
   * @api {get} /api/flash/comment/other 02. 快讯其他评论数据
   * @apiDescription 获取快讯其他评论数据
   * @apiGroup 52. 快讯评论模块
   *
   * @apiParam {string} flash_id 快讯编号
   * @apiParam {string} comment_id 基础评论编号
   *
   * @apiSuccess (字段说明|评论) {String} content 评论内容
   * @apiSuccess (字段说明|评论) {String} approval_total 点赞数量
   * @apiSuccess (字段说明|评论) {String} create_time 评论时间
   * @apiSuccess (字段说明|评论人) {String} avatar 评论人头像
   * @apiSuccess (字段说明|评论人) {String} nickname 评论人昵称
   *
   * @apiSampleRequest /api/flash/comment/other
   * @apiVersion 1.0.0
   */
  public function other(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $filter);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'other');

      $response = $this->_model::getList($condition, $relevance, $this->_order, true);

      array_splice($response, 0, 3);

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
