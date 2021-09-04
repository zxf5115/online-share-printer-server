<?php
namespace App\Http\Controllers\Api\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;
use App\Events\Api\Information\BrowseEvent;
use App\Models\Api\Module\Information\Similar;


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

  // 默认查询条件
  protected $_where = [
    'audit_status' => 1
  ];

  // 客户端搜索字段
  protected $_params = [
    'category_id',
    'subject_id',
    'title',
    'is_subject',
  ];


  // 附加搜索条件
  protected $_addition = [
    'labelRelevance' => [
      'label_id'
    ]
  ];


  // 排序方式
  protected $_order = [
    ['key' => 'is_top', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  // 关联对象
  protected $_relevance = [
    'list' => false,
    'subject' => false,
    'similar' => false,
    'view' => [
      'label',
      'member'
    ],
  ];


  /**
   * @api {get} /api/information/list?page={page} 01. 资讯列表
   * @apiDescription 获取资讯分页列表
   * @apiGroup 61. 资讯模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} category_id 分类编号
   * @apiParam {int} [title] 标题信息
   * @apiParam {int} [subject_id] 专题编号
   * @apiParam {int} [is_subject] 是否专题(普通资讯、专题资讯)
   *
   * @apiSuccess (字段说明) {Number} id 资讯编号
   * @apiSuccess (字段说明) {String} title 资讯标题
   * @apiSuccess (字段说明) {String} picture 资讯封面
   * @apiSuccess (字段说明) {String} content 资讯内容
   * @apiSuccess (字段说明) {String} source 资讯来源
   * @apiSuccess (字段说明) {String} author 资讯作者
   * @apiSuccess (字段说明) {String} read_total 阅读总数
   * @apiSuccess (字段说明) {String} is_top 是否置顶
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} is_comment 是否可以评论
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/information/list
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
   * @api {get} /api/information/recommend?page={page} 02. 推荐资讯列表
   * @apiDescription 获取推荐资讯分页列表
   * @apiGroup 61. 资讯模块
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
   * @apiSuccess (字段说明) {String} is_top 是否置顶
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} is_comment 是否可以评论
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/information/recommend
   * @apiVersion 1.0.0
   */
  public function recommend(Request $request)
  {
    try
    {
      $where = [
        'is_recommend' => 1
      ];

      $condition = self::getSimpleWhereData();

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
   * @api {get} /api/information/subject 03. 专题资讯数据
   * @apiDescription 获取专题资讯不分页数据列表
   * @apiGroup 61. 资讯模块
   *
   * @apiParam {int} total 显示数量(默认4个)
   *
   * @apiSuccess (字段说明) {Number} id 资讯编号
   * @apiSuccess (字段说明) {String} title 资讯标题
   * @apiSuccess (字段说明) {String} content 资讯内容
   * @apiSuccess (字段说明) {String} source 资讯来源
   * @apiSuccess (字段说明) {String} author 资讯作者
   * @apiSuccess (字段说明) {String} read_total 阅读总数
   * @apiSuccess (字段说明) {String} is_top 是否置顶
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} is_comment 是否可以评论
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/information/subject
   * @apiVersion 1.0.0
   */
  public function subject(Request $request)
  {
    try
    {
      $where = [
        'is_subject' => 1
      ];

      $total = $request->total ?? 4;

      $condition = self::getSimpleWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter, $where);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'subject');

      $response = $this->_model::getList($where, $relevance, $this->_order, false, $total);

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
   * @api {get} /api/information/similar 04. 相关资讯数据
   * @apiDescription 获取相关资讯不分页数据列表
   * @apiGroup 61. 资讯模块
   *
   * @apiParam {int} id 资讯编号
   * @apiParam {int} total 显示数量(默认4个)
   *
   * @apiSuccess (字段说明) {Number} id 资讯编号
   * @apiSuccess (字段说明) {String} title 资讯标题
   * @apiSuccess (字段说明) {String} content 资讯内容
   * @apiSuccess (字段说明) {String} source 资讯来源
   * @apiSuccess (字段说明) {String} author 资讯作者
   * @apiSuccess (字段说明) {String} read_total 阅读总数
   * @apiSuccess (字段说明) {String} is_top 是否置顶
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} is_comment 是否可以评论
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/information/similar
   * @apiVersion 1.0.0
   */
  public function similar(Request $request)
  {
    try
    {
      $total = $request->total ?? 4;

      $condition = self::getSimpleWhereData($request->id, 'information_id');

      $information_id = Similar::getPluck('similar_information_id', $condition, false, false, true);

      $where = [
        ['id', $information_id]
      ];

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'similar');

      $response = $this->_model::getList($where, $relevance, $this->_order, false, $total);

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
   * @api {get} /api/information/view/{id} 05. 资讯详情
   * @apiDescription 获取资讯详情
   * @apiGroup 61. 资讯模块
   *
   * @apiSuccess (字段说明|资讯) {Number} id 资讯编号
   * @apiSuccess (字段说明|资讯) {String} title 资讯标题
   * @apiSuccess (字段说明|资讯) {String} picture 资讯封面
   * @apiSuccess (字段说明|资讯) {String} content 资讯内容
   * @apiSuccess (字段说明|资讯) {String} source 资讯来源
   * @apiSuccess (字段说明|资讯) {String} author 资讯作者
   * @apiSuccess (字段说明|资讯) {String} read_total 阅读总数
   * @apiSuccess (字段说明|资讯) {String} is_top 是否置顶
   * @apiSuccess (字段说明|资讯) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明|资讯) {String} is_comment 是否可以评论
   * @apiSuccess (字段说明|资讯) {String} create_time 发布时间
   * @apiSuccess (字段说明|标签) {String} title 标签名字
   *
   * @apiSampleRequest /api/information/view/{id}
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

      $member_id = self::getCurrentId();

      $response['is_attention']  = $this->_model::getIsAttention($member_id, $id);
      $response['is_approval']   = $this->_model::getIsApproval($member_id, $id);
      $response['is_collection'] = $this->_model::getIsCollection($member_id, $id);

      // 记录资讯浏览总数
      event(new BrowseEvent($id));

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
