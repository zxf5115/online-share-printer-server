<?php
namespace App\Http\Controllers\Api\Module\Education\Courseware;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 课程老师控制器类
 */
class TeacherController extends BaseController
{
  // 模型
  protected $_model = 'App\Models\Api\Module\Education\Courseware\Teacher';

  // 排序
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @api {get} /api/education/courseware/teacher/select 01. 课程老师数据
   * @apiDescription 获取课程老师不分页列表
   * @apiGroup 42. 课程老师模块
   *
   * @apiSuccess (字段说明) {Number} id 课程老师编号
   * @apiSuccess (字段说明) {String} title 课程老师姓名
   * @apiSuccess (字段说明) {String} mobile 课程老师电话
   * @apiSuccess (字段说明) {String} picture 课程老师头像
   * @apiSuccess (字段说明) {Number} position 课程老师头衔
   * @apiSuccess (字段说明) {Number} content 课程老师介绍
   *
   * @apiSampleRequest /api/education/courseware/teacher/select
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
   * @api {get} /api/education/courseware/teacher/view/{id} 02. 课程老师详情
   * @apiDescription 获取课程老师详情
   * @apiGroup 42. 课程老师模块
   *
   * @apiSuccess (字段说明) {Number} id 课程老师编号
   * @apiSuccess (字段说明) {String} title 课程老师姓名
   * @apiSuccess (字段说明) {String} mobile 课程老师电话
   * @apiSuccess (字段说明) {String} picture 课程老师头像
   * @apiSuccess (字段说明) {Number} position 课程老师头衔
   * @apiSuccess (字段说明) {Number} content 课程老师介绍
   *
   * @apiSampleRequest /api/education/courseware/teacher/view/{id}
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
