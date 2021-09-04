<?php
namespace App\Http\Controllers\Api\Module\Problem;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 常见问题分类控制器类
 */
class CategoryController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Problem\Category';

  // 排序方式
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对象
  protected $_relevance = [
    'problem'
  ];


  /**
   * @api {get} /api/problem/category/select 01. 常见问题分类数据
   * @apiDescription 获取常见问题分类不分页列表数据
   * @apiGroup 07. 常见问题分类模块
   *
   * @apiSuccess (字段说明|问题分类) {Number} id 常见问题分类编号
   * @apiSuccess (字段说明|问题分类) {String} title 常见问题分类标题
   * @apiSuccess (字段说明|问题) {String} title 常见问题标题
   * @apiSuccess (字段说明|问题) {String} content 常见问题内容
   *
   * @apiSampleRequest /api/problem/category/select
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
