<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-22
 *
 * 社区控制器类
 */
class CommunityController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Community';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
  ];

  /**
   * @api {get} /api/member/community/list?page={page} 01. 我的社区列表
   * @apiDescription 获取我的社区分页列表
   * @apiGroup 31. 会员社区模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} category_id 社区分类编号
   *
   * @apiSuccess (字段说明) {Number} id 社区编号
   * @apiSuccess (字段说明) {String} title 社区标题
   * @apiSuccess (字段说明) {String} picture 社区封面
   * @apiSuccess (字段说明) {String} content 社区内容
   * @apiSuccess (字段说明) {String} author 社区作者
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/member/community/list
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
   * @api {get} /api/member/community/view/{id} 02. 我的社区详情
   * @apiDescription 获取我的社区详情
   * @apiGroup 31. 会员社区模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {Number} id 社区编号
   * @apiSuccess (字段说明) {String} title 社区标题
   * @apiSuccess (字段说明) {String} picture 社区封面
   * @apiSuccess (字段说明) {String} content 社区内容
   * @apiSuccess (字段说明) {String} author 社区作者
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/member/community/view/{id}
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
   * @api {post} /api/member/community/handle 03. 社区发布
   * @apiDescription 当前会员社区发布
   * @apiGroup 31. 会员社区模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} category_id 社区分类
   * @apiParam {string} title 社区标题
   * @apiParam {string} picture 社区封面
   * @apiParam {string} content 社区内容
   * @apiParam {string} author 社区作者
   *
   * @apiSampleRequest /api/member/community/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'category_id.required' => '请您输入社区分类',
      'title.required'       => '请您输入社区标题',
      'picture.required'     => '请您输入社区封面',
      'content.required'     => '请您输入社区内容',
    ];

    $rule = [
      'category_id' => 'required',
      'title'       => 'required',
      'picture'     => 'required',
      'content'     => 'required',
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

        $model->category_id = $request->category_id;
        $model->member_id   = self::getCurrentId();
        $model->title       = $request->title;
        $model->picture     = $request->picture;
        $model->content     = $request->content;
        $model->author      = self::getCurrentNickname();
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
