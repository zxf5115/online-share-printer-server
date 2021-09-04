<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;
use App\Models\Common\Module\Information\Sensitive;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯控制器类
 */
class InformationController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Information';


  // 附加搜索条件
  protected $_addition = [
    'labelRelevance' => [
      'label_id'
    ]
  ];


  // 关联对象
  protected $_relevance = [
    'list' => false,
    'related' => [
      'labelRelevance'
    ],
    'view' => [
      'label'
    ],
  ];


  /**
   * @api {get} /api/member/information/list?page={page} 01. 我的资讯列表
   * @apiDescription 获取我的资讯分页列表
   * @apiGroup 27. 会员资讯模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明) {Number} id 资讯编号
   * @apiSuccess (字段说明) {String} title 资讯标题
   * @apiSuccess (字段说明) {String} picture 资讯封面
   * @apiSuccess (字段说明) {String} content 资讯内容
   * @apiSuccess (字段说明) {String} source 资讯来源
   * @apiSuccess (字段说明) {String} author 资讯作者
   * @apiSuccess (字段说明) {String} read_total 阅读总数
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/member/information/list
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
   * @api {get} /api/member/information/view/{id} 02. 我的资讯详情
   * @apiDescription 获取我的资讯详情
   * @apiGroup 27. 会员资讯模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {Number} id 资讯编号
   * @apiSuccess (字段说明) {String} title 资讯标题
   * @apiSuccess (字段说明) {String} picture 资讯封面
   * @apiSuccess (字段说明) {String} content 资讯内容
   * @apiSuccess (字段说明) {String} source 资讯来源
   * @apiSuccess (字段说明) {String} author 资讯作者
   * @apiSuccess (字段说明) {String} read_total 阅读总数
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/member/information/view/{id}
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
   * @api {post} /api/member/information/handle 03. 资讯发布
   * @apiDescription 当前会员资讯发布
   * @apiGroup 27. 会员资讯模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} category_id 资讯分类
   * @apiParam {string} title 资讯标题
   * @apiParam {string} picture 资讯封面
   * @apiParam {string} content 资讯内容
   * @apiParam {string} [source] 资讯来源
   *
   * @apiSampleRequest /api/member/information/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'category_id.required' => '请您输入资讯分类',
      'title.required'       => '请您输入资讯标题',
      'picture.required'     => '请您输入资讯封面',
      'content.required'     => '请您输入资讯内容',
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
        $model->title       = Sensitive::shield($request->title);
        $model->picture     = $request->picture;
        $model->content     = Sensitive::shield($request->content);
        $model->source      = $request->source ?? '';
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



  /**
   * @api {post} /api/member/information/delete 04. 资讯删除
   * @apiDescription 当前会员资讯发布
   * @apiGroup 27. 会员资讯模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} id 资讯编号
   *
   * @apiSampleRequest /api/member/information/delete
   * @apiVersion 1.0.0
   */
  public function delete(Request $request)
  {
    try
    {
      $response = $this->_model::remove($request->id);

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
