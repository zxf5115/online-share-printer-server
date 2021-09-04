<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Events\Api\Member\PayEvent;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 会员资产明细控制器类
 */
class MoneyController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\Money';

  // 客户端搜索字段
  protected $_where = [
    'confirm_status' => 1
  ];


  /**
   * @api {get} /api/member/money/list 01. 我的收支记录
   * @apiDescription 获取当前会员的收支记录
   * @apiGroup 33. 会员资产明细模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {String} type 收支类型
   * @apiSuccess (字段说明) {String} money 收支金额
   * @apiSuccess (字段说明) {String} create_time 收支时间
   *
   * @apiSampleRequest /api/member/money/list
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
   * @api {get} /api/member/money/income 02. 我的充值记录
   * @apiDescription 获取当前会员的充值记录
   * @apiGroup 33. 会员资产明细模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {String} money 收支金额
   * @apiSuccess (字段说明) {String} create_time 收支时间
   *
   * @apiSampleRequest /api/member/money/income
   * @apiVersion 1.0.0
   */
  public function income(Request $request)
  {
    try
    {
      $where = [
        'type' => 1
      ];

      $condition = self::getCurrentWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter, $where);

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
   * @api {get} /api/member/money/expend 03. 我的消费记录
   * @apiDescription 获取当前会员的消费记录
   * @apiGroup 33. 会员资产明细模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {String} money 收支金额
   * @apiSuccess (字段说明) {String} create_time 收支时间
   *
   * @apiSampleRequest /api/member/money/expend
   * @apiVersion 1.0.0
   */
  public function expend(Request $request)
  {
    try
    {
      $where = [
        'type' => 2
      ];

      $condition = self::getCurrentWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter, $where);

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
   * @api {post} /api/member/money/handle 04. 充值操作
   * @apiDescription 当前会员充值
   * @apiGroup 33. 会员资产明细模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} money 充值金额
   * @apiParam {string} pay_type 充值方式
   *
   * @apiSampleRequest /api/member/money/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'money.required'    => '请您输入充值金额',
      'pay_type.required' => '请您选择充值方式',
    ];

    $rule = [
      'money'    => 'required',
      'pay_type' => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $member_id = self::getCurrentId();

        $model->member_id = $member_id;
        $model->type      = 1;
        $model->money     = $request->money;
        $model->pay_type  = $request->pay_type;
        $model->save();

        // 支付
        event(new PayEvent($model));

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
