<?php
namespace App\Http\Controllers\Api\Module\Information;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-14
 *
 * 资讯专题控制器类
 */
class SubjectController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Information\Subject';

  // 排序方式
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @api {get} /api/information/subject/select 01. 资讯专题数据
   * @apiDescription 获取资讯专题不分页列表数据
   * @apiGroup 65. 资讯专题模块
   *
   * @apiSuccess (字段说明) {Number} id 资讯专题编号
   * @apiSuccess (字段说明) {String} title 资讯专题标题
   *
   * @apiSampleRequest /api/information/subject/select
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
