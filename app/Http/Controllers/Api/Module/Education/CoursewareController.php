<?php
namespace App\Http\Controllers\Api\Module\Education;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 课程控制器类
 */
class CoursewareController extends BaseController
{
  // 模型
  protected $_model = 'App\Models\Api\Module\Education\Courseware';

  // 查询条件
  protected $_params = [
    'title',
    'category_id',
    'teacher_id'
  ];

  // 排序
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联数组
  protected $_relevance = [
    'list' => false,
    'recommend' => [
      'category',
      'teacher'
    ],
    'view' => [
      'category',
      'teacher'
    ]
  ];


  /**
   * @api {get} /api/education/courseware/list?page={page} 01. 课程列表
   * @apiDescription 获取课程分页列表
   * @apiGroup 41. 课程模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {String} title 课程标题
   *
   * @apiSuccess (字段说明) {Number} id 课程编号
   * @apiSuccess (字段说明) {String} code 课程代码
   * @apiSuccess (字段说明) {String} title 课程名称
   * @apiSuccess (字段说明) {String} picture 课程图片
   * @apiSuccess (字段说明) {String} content 课程内容
   * @apiSuccess (字段说明) {String} money 课程价格
   * @apiSuccess (字段说明) {String} point_total 课程集数
   * @apiSuccess (字段说明) {String} watch_total 观看总数
   * @apiSuccess (字段说明) {String} is_shelf 是否上架
   * @apiSuccess (字段说明) {String} is_trial 是否试看
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   *
   * @apiSampleRequest /api/education/courseware/list
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
   * @api {get} /api/education/courseware/recommend 02. 推荐课程
   * @apiDescription 获取推荐课程数据
   * @apiGroup 41. 课程模块
   *
   * @apiParam {int} category_id 课程分类编号
   * @apiParam {int} total 显示数量，默认显示4个
   *
   * @apiSuccess (字段说明) {Number} id 课程编号
   * @apiSuccess (字段说明) {String} code 课程代码
   * @apiSuccess (字段说明) {String} title 课程名称
   * @apiSuccess (字段说明) {String} picture 课程图片
   * @apiSuccess (字段说明) {String} content 课程内容
   * @apiSuccess (字段说明) {String} money 课程价格
   * @apiSuccess (字段说明) {String} point_total 课程集数
   * @apiSuccess (字段说明) {String} watch_total 观看总数
   * @apiSuccess (字段说明) {String} is_shelf 是否上架
   * @apiSuccess (字段说明) {String} is_trial 是否试看
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   *
   * @apiSampleRequest /api/education/courseware/recommend
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
   * @api {get} /api/education/courseware/view/{id} 03. 课程详情
   * @apiDescription 获取课程详情
   * @apiGroup 41. 课程模块
   *
   * @apiSuccess (字段说明|课程) {Number} id 课程编号
   * @apiSuccess (字段说明|课程) {String} code 课程代码
   * @apiSuccess (字段说明|课程) {String} title 课程名称
   * @apiSuccess (字段说明|课程) {String} picture 课程图片
   * @apiSuccess (字段说明|课程) {String} content 课程内容
   * @apiSuccess (字段说明|课程) {String} money 课程价格
   * @apiSuccess (字段说明|课程) {String} point_total 课程集数
   * @apiSuccess (字段说明|课程) {String} watch_total 观看总数
   * @apiSuccess (字段说明|课程) {String} is_shelf 是否上架
   * @apiSuccess (字段说明|课程) {String} is_trial 是否试看
   * @apiSuccess (字段说明|课程) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明|课程分类) {String} id 课程分类编号
   * @apiSuccess (字段说明|课程分类) {String} title 课程分类名称
   * @apiSuccess (字段说明|课程老师) {String} id 课程老师编号
   * @apiSuccess (字段说明|课程老师) {String} title 课程老师姓名
   * @apiSuccess (字段说明|课程老师) {String} mobile 课程老师电话
   * @apiSuccess (字段说明|课程老师) {String} picture 课程老师头像
   * @apiSuccess (字段说明|课程老师) {String} position 课程老师头衔
   * @apiSuccess (字段说明|课程老师) {String} content 课程老师介绍
   *
   * @apiSampleRequest /api/education/courseware/view/{id}
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
