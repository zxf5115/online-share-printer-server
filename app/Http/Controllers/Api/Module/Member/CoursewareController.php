<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Enum\Common\TimeEnum;
use App\Events\Api\Member\Share\MoneyEvent;
use App\Http\Controllers\Api\BaseController;
use App\Models\Api\Module\Member\Relevance\Asset;
use App\Models\Api\Module\Member\Relevance\Relevance\Unit;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 会员课程控制器类
 */
class CoursewareController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\Courseware';

  // 附加搜索条件
  protected $_params = [
    'is_finish'
  ];

  // 关联对象
  protected $_relevance = [
    'list' => [
      'courseware',
    ],
    'view' => [
      'courseware',
    ]
  ];


  /**
   * @api {get} /api/member/courseware/list?page={page} 01. 我的课程列表
   * @apiDescription 获取当前会员的课程分页列表
   * @apiGroup 35. 会员课程模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|会员课程) {String} id 会员课程编号
   * @apiSuccess (字段说明|会员课程) {String} courseware_id 课程编号
   * @apiSuccess (字段说明|会员课程) {String} is_finish 是否完成学习
   * @apiSuccess (字段说明|会员课程) {String} create_time 添加时间
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
   *
   * @apiSampleRequest /api/member/courseware/list
   * @apiVersion 1.0.0
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getCurrentWhereData();

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
   * @api {get} /api/member/courseware/status/{id} 02. 当前课程是否被购买
   * @apiDescription 获取当前课程是否被当前会员购买
   * @apiGroup 35. 会员课程模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} id 课程编号
   *
   * @apiSuccess (字段说明) {Boolean} true|false 是否订阅
   *
   * @apiSampleRequest /api/member/courseware/status/{id}
   * @apiVersion 1.0.0
   */
  public function status(Request $request, $id)
  {
    try
    {
      $response = true;

      $condition = self::getCurrentWhereData();

      $where = ['courseware_id' => $id];

      $condition = array_merge($condition, $where);

      $result = $this->_model::getRow($condition);

      if(empty($result->id))
      {
        $response = false;
      }

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
   * @api {get} /api/member/courseware/view/{id} 03. 我的课程详情
   * @apiDescription 获取当前会员课程详情
   * @apiGroup 35. 会员课程模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} id 课程编号
   *
   * @apiSuccess (字段说明|会员课程) {String} id 会员课程编号
   * @apiSuccess (字段说明|会员课程) {String} courseware_id 课程编号
   * @apiSuccess (字段说明|会员课程) {String} is_finish 是否完成学习
   * @apiSuccess (字段说明|会员课程) {String} create_time 添加时间
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
   *
   * @apiSampleRequest /api/member/courseware/view/{id}
   * @apiVersion 1.0.0
   */
  public function view(Request $request, $id)
  {
    try
    {
      $condition = self::getCurrentWhereData();

      $where = ['courseware_id' => $id];

      $condition = array_merge($condition, $where);

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


  /**
   * @api {post} /api/member/courseware/finish 04. 完成课程
   * @apiDescription 当前会员学习完成了课程
   * @apiGroup 35. 会员课程模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} id 课程编号
   *
   * @apiSampleRequest /api/member/courseware/finish
   * @apiVersion 1.0.0
   */
  public function finish(Request $request)
  {
    $messages = [
      'id.required' => '请您输入课程编号'
    ];

    $rule = [
      'id' => 'required'
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      try
      {
        $condition = self::getCurrentWhereData();

        $where = ['courseware_id' => $request->id];

        $condition = array_merge($condition, $where);

        $model = $this->_model::getRow($condition);

        if(1 == $model->is_finish['value'])
        {
          return self::error(Code::COURSE_FINISH);
        }

        $model->is_finish = 1;
        $model->save();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @api {post} /api/member/courseware/expense 05. 课程学习
   * @apiDescription 当前贵宾会员学习课程
   * @apiGroup 35. 会员课程模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} id 课程编号
   *
   * @apiSampleRequest /api/member/courseware/expense
   * @apiVersion 1.0.0
   */
  public function expense(Request $request)
  {
    $messages = [
      'id.required' => '请您输入课程编号'
    ];

    $rule = [
      'id' => 'required'
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      try
      {
        $model = $this->_model::firstOrNew([
          'member_id' => self::getCurrentId(),
          'courseware_id' => $request->id
        ]);

        if(empty($model->id))
        {
          $model->source = 2;
          $model->save();;
        }

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
