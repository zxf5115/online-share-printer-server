<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 我的投诉控制器类
 */
class ComplainController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Complain';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
  ];

  // 关联对象
  protected $_relevance = [
    'category'
  ];


  /**
   * @api {get} /api/member/complain/list?page={page} 01. 我的投诉列表
   * @apiDescription 获取我的投诉分页列表
   * @apiGroup 25. 会员投诉模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} category_id 投诉位编号
   *
   * @apiSuccess (字段说明|投诉) {Number} id 投诉编号
   * @apiSuccess (字段说明|投诉) {String} title 投诉标题
   * @apiSuccess (字段说明|投诉) {String} content 投诉内容
   * @apiSuccess (字段说明|投诉) {String} customer_name 客户姓名
   * @apiSuccess (字段说明|投诉) {String} contact 联系方式
   * @apiSuccess (字段说明|投诉) {Number} create_time 投诉时间
   * @apiSuccess (字段说明|投诉分类) {Number} title 投诉分类标题
   *
   * @apiSampleRequest /api/member/complain/list
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
   * @api {get} /api/member/complain/view/{id} 02. 我的投诉详情
   * @apiDescription 获取我的投诉详情
   * @apiGroup 25. 会员投诉模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明|投诉) {Number} id 投诉编号
   * @apiSuccess (字段说明|投诉) {String} title 投诉标题
   * @apiSuccess (字段说明|投诉) {String} content 投诉内容
   * @apiSuccess (字段说明|投诉) {String} customer_name 客户姓名
   * @apiSuccess (字段说明|投诉) {String} contact 联系方式
   * @apiSuccess (字段说明|投诉) {Number} create_time 投诉时间
   * @apiSuccess (字段说明|投诉分类) {Number} title 投诉分类标题
   *
   * @apiSampleRequest /api/member/complain/view/{id}
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

  /**
   * @api {post} /api/member/complain/handle 03. 提交投诉信息
   * @apiDescription 提交投诉信息
   * @apiGroup 25. 会员投诉模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} category_id 投诉类型（不可为空）
   * @apiParam {string} title 投诉标题（不可为空）
   * @apiParam {string} content 投诉内容
   * @apiParam {string} customer_name 客户姓名（不可为空）
   * @apiParam {string} contact 联系方式（不可为空）
   *
   * @apiSampleRequest /api/member/complain/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'category_id.required'   => '请您输入投诉分类',
      'title.required'         => '请您输入投诉标题',
      'customer_name.required' => '请您输入客户姓名',
      'contact.required'       => '请您输入联系方式',
    ];

    $rule = [
      'category_id'   => 'required',
      'title' => 'required',
      'customer_name' => 'required',
      'contact'       => 'required',
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
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $model->category_id   = $request->category_id;
        $model->member_id     = self::getCurrentId();
        $model->title         = $request->title;
        $model->content       = $request->content ?? '';
        $model->customer_name = $request->customer_name;
        $model->contact       = $request->contact;
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
}
