<?php
namespace App\Http\Controllers\Api\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-19
 *
 * 贵宾控制器类
 */
class VipController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Vip';


  /**
   * @api {get} /api/vip/list?page={page} 01. 贵宾列表
   * @apiDescription 获取贵宾分页列表
   * @apiGroup 19. 贵宾模块
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明) {Number} id 贵宾编号
   * @apiSuccess (字段说明) {String} title 贵宾标题
   * @apiSuccess (字段说明) {String} content 贵宾内容
   * @apiSuccess (字段说明) {String} money 贵宾费用
   * @apiSuccess (字段说明) {String} valid_time 贵宾时限(月)
   *
   * @apiSampleRequest /api/vip/list
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
   * @api {get} /api/vip/select 02. 贵宾数据
   * @apiDescription 获取贵宾不分页列表数据
   * @apiGroup 19. 贵宾模块
   *
   * @apiSuccess (字段说明) {Number} id 贵宾编号
   * @apiSuccess (字段说明) {String} title 贵宾标题
   * @apiSuccess (字段说明) {String} content 贵宾内容
   * @apiSuccess (字段说明) {String} money 贵宾费用
   * @apiSuccess (字段说明) {String} valid_time 贵宾时限(月)
   *
   * @apiSampleRequest /api/vip/select
   * @apiVersion 1.0.0
   */
  public function select(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'select');

      $response = $this->_model::getList($condition, $relevance, $this->_order);

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
   * @api {get} /api/vip/view/{id} 03. 贵宾详情
   * @apiDescription 获取贵宾详情
   * @apiGroup 19. 贵宾模块
   *
   * @apiSuccess (字段说明) {Number} id 贵宾编号
   * @apiSuccess (字段说明) {String} title 贵宾标题
   * @apiSuccess (字段说明) {String} content 贵宾内容
   * @apiSuccess (字段说明) {String} money 贵宾费用
   * @apiSuccess (字段说明) {String} valid_time 贵宾时限(月)
   *
   * @apiSampleRequest /api/vip/view/{id}
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
