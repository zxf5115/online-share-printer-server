<?php
namespace App\Http\Controllers\Api\Module\Education\Courseware;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 课程分类控制器类
 */
class CategoryController extends BaseController
{
  // 模型
  protected $_model = 'App\Models\Api\Module\Education\Courseware\Category';

  // 排序
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @api {get} /api/education/courseware/category/select 01. 课程分类数据
   * @apiDescription 获取课程分类不分页列表
   * @apiGroup 40. 课程分类模块
   *
   * @apiSuccess (basic params) {Number} id 课程分类编号
   * @apiSuccess (basic params) {String} title 课程分类名称
   *
   * @apiSampleRequest /api/education/courseware/category/select
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
