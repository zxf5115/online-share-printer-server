<?php
namespace App\Http\Controllers\Api\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-02-22
 *
 * 常见问题控制器类
 */
class ProblemController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Problem';


  /**
   * @api {get} /api/problem/list?page={page} 01. 常见问题列表
   * @apiDescription 获取常见问题分页列表
   * @apiGroup 08. 常见问题模块
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明) {Number} id 常见问题编号
   * @apiSuccess (字段说明) {String} title 常见问题标题
   * @apiSuccess (字段说明) {String} content 常见问题内容
   *
   * @apiSampleRequest /api/problem/list
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
   * @api {get} /api/problem/select 02. 常见问题数据
   * @apiDescription 获取常见问题不分页列表数据
   * @apiGroup 08. 常见问题模块
   *
   * @apiSuccess (字段说明) {Number} id 常见问题编号
   * @apiSuccess (字段说明) {String} title 常见问题标题
   * @apiSuccess (字段说明) {String} content 常见问题内容
   *
   * @apiSampleRequest /api/problem/select
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
   * @api {get} /api/problem/view/{id} 03. 常见问题详情
   * @apiDescription 获取常见问题详情
   * @apiGroup 08. 常见问题模块
   *
   * @apiSuccess (字段说明) {Number} id 常见问题编号
   * @apiSuccess (字段说明) {String} title 常见问题标题
   * @apiSuccess (字段说明) {String} content 常见问题内容
   *
   * @apiSampleRequest /api/problem/view/{id}
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
