<?php
namespace App\Http\Controllers\Api\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\TraitClass\ToolTrait;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 快讯控制器类
 */
class FlashController extends BaseController
{
  use ToolTrait;

  // 模型名称
  protected $_model = 'App\Models\Api\Module\Flash';

  // 默认查询条件
  protected $_where = [
    'audit_status' => 1
  ];

  // 客户端搜索字段
  protected $_params = [
    'category_id'
  ];


  /**
   * @api {get} /api/flash/list?page={page} 01. 快讯列表
   * @apiDescription 获取快讯分页列表
   * @apiGroup 51. 快讯模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} category_id 分类编号
   *
   * @apiSuccess (字段说明) {Number} id 快讯编号
   * @apiSuccess (字段说明) {String} title 快讯标题
   * @apiSuccess (字段说明) {String} content 快讯内容
   * @apiSuccess (字段说明) {String} bullish_total 利多总数
   * @apiSuccess (字段说明) {String} bearish_total 利空总数
   * @apiSuccess (字段说明) {String} is_benefit 利空利多 0 未知 1 利多 2 利空
   * @apiSuccess (字段说明) {String} is_recommend 首页推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/flash/list
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

      $response = self::allocation($response, 'datetime');

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
   * @api {get} /api/flash/recommend 02. 推荐快讯
   * @apiDescription 获取推荐快讯数据
   * @apiGroup 51. 快讯模块
   *
   * @apiParam {int} category_id 分类编号
   * @apiParam {int} total 显示数量，默认显示4个
   *
   * @apiSuccess (字段说明) {Number} id 快讯编号
   * @apiSuccess (字段说明) {String} title 快讯标题
   * @apiSuccess (字段说明) {String} content 快讯内容
   * @apiSuccess (字段说明) {String} bullish_total 利多总数
   * @apiSuccess (字段说明) {String} bearish_total 利空总数
   * @apiSuccess (字段说明) {String} is_benefit 利空利多 0 未知 1 利多 2 利空
   * @apiSuccess (字段说明) {String} is_recommend 首页推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/flash/recommend
   * @apiVersion 1.0.0
   */
  public function recommend(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData(1, 'is_recommend');

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $total = $request->total ?? 4;

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'recommend');

      $response = $this->_model::getList($condition, $relevance, $this->_order, false, $total);

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
   * @api {get} /api/flash/view/{id} 03. 快讯详情
   * @apiDescription 获取快讯详情
   * @apiGroup 51. 快讯模块
   *
   * @apiSuccess (字段说明) {Number} id 快讯编号
   * @apiSuccess (字段说明) {String} title 快讯标题
   * @apiSuccess (字段说明) {String} content 快讯内容
   * @apiSuccess (字段说明) {String} bullish_total 利多总数
   * @apiSuccess (字段说明) {String} bearish_total 利空总数
   * @apiSuccess (字段说明) {String} is_benefit 利空利多 0 未知 1 利多 2 利空
   * @apiSuccess (字段说明) {String} is_recommend 首页推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/flash/view/{id}
   * @apiVersion 1.0.0
   */
  public function view(Request $request, $id)
  {
    try
    {
      $condition = self::getSimpleWhereData($id);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'view');

      $response = $this->_model::getRow($condition, $relevance);

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
