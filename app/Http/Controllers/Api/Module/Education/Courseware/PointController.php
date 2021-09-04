<?php
namespace App\Http\Controllers\Api\Module\Education\Courseware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;
use App\Events\Api\Education\Courseware\Point\WatchEvent;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 课程知识点控制器类
 */
class PointController extends BaseController
{
  // 模型
  protected $_model = 'App\Models\Api\Module\Education\Courseware\Point';

  // 查询条件
  protected $_params = [
    'courseware_id'
  ];

  // 排序
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联数组
  protected $_relevance = [
    'list' => false,
    'select' => false,
    'view' => [
      'courseware.teacher',
      'courseware.recommend',
    ]
  ];


  /**
   * @api {get} /api/education/courseware/point/list?page={page} 01. 课程知识点列表
   * @apiDescription 获取课程知识点分页列表
   * @apiGroup 43. 课程知识点模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} courseware_id 课程编号
   *
   * @apiSuccess (字段说明) {Number} id 课程知识点编号
   * @apiSuccess (字段说明) {Number} courseware_id 课程编号
   * @apiSuccess (字段说明) {String} title 课程知识点名称
   * @apiSuccess (字段说明) {String} picture 课程知识点封面
   * @apiSuccess (字段说明) {Number} url 课程知识点视频
   * @apiSuccess (字段说明) {Number} approval_total 点赞总数
   * @apiSuccess (字段说明) {Number} create_time 发布时间
   *
   * @apiSampleRequest /api/education/courseware/point/list
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
   * @api {get} /api/education/courseware/point/select 02. 课程知识点数据
   * @apiDescription 获取课程知识点不分页列表
   * @apiGroup 43. 课程知识点模块
   *
   * @apiParam {int} courseware_id 课程编号
   *
   * @apiSuccess (字段说明) {Number} id 课程知识点编号
   * @apiSuccess (字段说明) {Number} courseware_id 课程编号
   * @apiSuccess (字段说明) {String} title 课程知识点名称
   * @apiSuccess (字段说明) {String} picture 课程知识点封面
   * @apiSuccess (字段说明) {Number} url 课程知识点视频
   * @apiSuccess (字段说明) {Number} approval_total 点赞总数
   * @apiSuccess (字段说明) {Number} create_time 发布时间
   *
   * @apiSampleRequest /api/education/courseware/point/select
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
   * @api {get} /api/education/courseware/point/view/{id} 03. 课程知识点详情
   * @apiDescription 获取课程知识点详情
   * @apiGroup 43. 课程知识点模块
   *
   * @apiSuccess (字段说明) {Number} id 课程知识点编号
   * @apiSuccess (字段说明) {Number} courseware_id 课程编号
   * @apiSuccess (字段说明) {String} title 课程知识点名称
   * @apiSuccess (字段说明) {String} picture 课程知识点封面
   * @apiSuccess (字段说明) {Number} url 课程知识点视频
   * @apiSuccess (字段说明) {Number} approval_total 点赞总数
   * @apiSuccess (字段说明) {Number} create_time 发布时间
   *
   * @apiSampleRequest /api/education/courseware/point/view/{id}
   * @apiVersion 1.0.0
   */
  public function view(Request $request, $id)
  {
    DB::beginTransaction();

    try
    {
      $condition = self::getSimpleWhereData($id);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'view');

      $response = $this->_model::getRow($condition, $relevance);

      // 记录课程知识点浏览
      event(new WatchEvent($id));

      DB::commit();

      return self::success($response);
    }
    catch(\Exception $e)
    {
      DB::rollback();

      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
