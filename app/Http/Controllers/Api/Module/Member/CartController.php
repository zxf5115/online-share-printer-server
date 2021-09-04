<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-26
 *
 * 会员购物车控制器类
 */
class CartController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\Cart';


  // 关联对像
  protected $_relevance = [
    'select' => [
      'courseware',
    ]
  ];


  /**
   * @api {get} /api/member/cart/select 01. 我的购物车数据
   * @apiDescription 获取我的购物车数据
   * @apiGroup 34. 会员购物车模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明|课程) {Number} id 资讯编号

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
   * @apiSampleRequest /api/member/cart/select
   * @apiVersion 1.0.0
   */
  public function select(Request $request)
  {
    try
    {
      $condition = self::getCurrentWhereData();

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
   * @api {post} /api/member/cart/add 02. 加入购物车
   * @apiDescription 当前会员把课程加入购物车
   * @apiGroup 34. 会员购物车模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} courseware_id 课程编号
   * @apiParam {string} total 购买数量
   *
   * @apiSampleRequest /api/member/cart/add
   * @apiVersion 1.0.0
   */
  public function add(Request $request)
  {
    $messages = [
      'courseware_id.required' => '请您输入课程编号',
      'total.required'         => '请您输入购买数量',
    ];

    $rule = [
      'courseware_id' => 'required',
      'total'         => 'required',
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
        $member_id     = self::getCurrentId();
        $courseware_id = $request->courseware_id;

        $model = $this->_model::firstOrNew([
          'member_id' => $member_id,
          'courseware_id' => $courseware_id
        ]);

        if(empty($model->id))
        {
          $model->save();
        }
        else
        {
          return self::error(Code::ALREADY_ADD_CART);
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


  /**
   * @api {post} /api/member/cart/change 03. 修改数量
   * @apiDescription 当前会员修改购物车课程数量
   * @apiGroup 34. 会员购物车模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} id 购物车编号
   *
   * @apiSampleRequest /api/member/cart/change
   * @apiVersion 1.0.0
   */
  public function change(Request $request)
  {
    $messages = [
      'id.required'    => '请您输入购物车编号',
      'total.required' => '请您输入购买数量',
    ];

    $rule = [
      'id'    => 'required',
      'total' => 'required',
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
        $model = $this->_model::find($request->id);
        $model->total = $request->total;
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
   * @api {post} /api/member/cart/delete 04. 删除购物车
   * @apiDescription 当前会员把课程删除购物车
   * @apiGroup 34. 会员购物车模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} id 购物车编号
   *
   * @apiSampleRequest /api/member/cart/delete
   * @apiVersion 1.0.0
   */
  public function delete(Request $request)
  {
    $messages = [
      'id.required' => '请您输入购物车编号',
    ];

    $rule = [
      'id' => 'required',
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
        $this->_model::destroy($request->id);

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
