<?php
namespace App\Http\Controllers\Api\Module\Complain;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 投诉分类控制器类
 */
class CategoryController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Complain\Category';

  // 排序条件
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @api {get} /api/complain/category/select 01. 投诉分类数据
   * @apiDescription 获取投诉分类不分页列表数据
   * @apiGroup 06. 投诉分类模块
   *
   * @apiSuccess (字段说明) {Number} id 投诉分类编号
   * @apiSuccess (字段说明) {String} title 投诉分类标题
   *
   * @apiSampleRequest /api/complain/category/select
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
}
