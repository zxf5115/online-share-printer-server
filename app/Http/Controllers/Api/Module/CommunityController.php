<?php
namespace App\Http\Controllers\Api\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-31
 *
 * 社区控制器类
 */
class CommunityController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Community';

  // 默认查询条件
  protected $_where = [
    // 'is_hot' => 1
  ];

  // 客户端搜索字段
  protected $_params = [
    'category_id',
    'member_id'
  ];


  // 关联对象
  protected $_relevance = [
    'category',
    'member'
  ];

  /**
   * @api {get} /api/community/list?page={page} 01. 社区列表
   * @apiDescription 获取社区分页列表
   * @apiGroup 71. 社区模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {int} category_id 社区分类编号
   * @apiParam {int} member_id 会员编号
   *
   * @apiSuccess (字段说明) {Number} id 社区编号
   * @apiSuccess (字段说明) {String} title 社区标题
   * @apiSuccess (字段说明) {String} picture 社区封面
   * @apiSuccess (字段说明) {String} content 社区内容
   * @apiSuccess (字段说明) {String} author 社区作者
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} read_total 阅读数量
   * @apiSuccess (字段说明) {String} approval_total 点赞数量
   * @apiSuccess (字段说明) {String} comment_total 评论数量
   * @apiSuccess (字段说明) {String} collection_total 收藏数量
   * @apiSuccess (字段说明) {String} is_approval 是否点赞
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/community/list
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
   * @api {get} /api/community/recommend 02. 推荐社区数据
   * @apiDescription 获取推荐社区数据列表
   * @apiGroup 71. 社区模块
   *
   * @apiParam {int} total 显示数量，默认显示6个
   *
   * @apiSuccess (字段说明) {Number} id 社区编号
   * @apiSuccess (字段说明) {String} title 社区标题
   * @apiSuccess (字段说明) {String} picture 社区封面
   * @apiSuccess (字段说明) {String} content 社区内容
   * @apiSuccess (字段说明) {String} author 社区作者
   * @apiSuccess (字段说明) {String} read_total 阅读数量
   * @apiSuccess (字段说明) {String} approval_total 点赞数量
   * @apiSuccess (字段说明) {String} comment_total 评论数量
   * @apiSuccess (字段说明) {String} collection_total 收藏数量
   * @apiSuccess (字段说明) {String} is_approval 是否点赞
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/community/recommend
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

      $total = $request->total ?? 6;

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'list');

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
   * @api {get} /api/community/hot 03. 热门社区数据
   * @apiDescription 获取热门社区数据列表
   * @apiGroup 71. 社区模块
   *
   * @apiParam {int} total 显示数量，默认显示6个
   *
   * @apiSuccess (字段说明) {Number} id 社区编号
   * @apiSuccess (字段说明) {String} title 社区标题
   * @apiSuccess (字段说明) {String} picture 社区封面
   * @apiSuccess (字段说明) {String} content 社区内容
   * @apiSuccess (字段说明) {String} author 社区作者
   * @apiSuccess (字段说明) {String} read_total 阅读数量
   * @apiSuccess (字段说明) {String} approval_total 点赞数量
   * @apiSuccess (字段说明) {String} comment_total 评论数量
   * @apiSuccess (字段说明) {String} collection_total 收藏数量
   * @apiSuccess (字段说明) {String} is_approval 是否点赞
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/community/hot
   * @apiVersion 1.0.0
   */
  public function hot(Request $request)
  {
    try
    {
      $where = [
        'is_hot' => 1
      ];

      $condition = self::getSimpleWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter, $where);

      $total = $request->total ?? 6;

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'list');

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
   * @api {get} /api/community/view/{id} 04. 社区详情
   * @apiDescription 获取社区详情
   * @apiGroup 71. 社区模块
   *
   * @apiSuccess (字段说明) {Number} id 社区编号
   * @apiSuccess (字段说明) {String} title 社区标题
   * @apiSuccess (字段说明) {String} picture 社区封面
   * @apiSuccess (字段说明) {String} content 社区内容
   * @apiSuccess (字段说明) {String} author 社区作者
   * @apiSuccess (字段说明) {String} read_total 阅读数量
   * @apiSuccess (字段说明) {String} approval_total 点赞数量
   * @apiSuccess (字段说明) {String} comment_total 评论数量
   * @apiSuccess (字段说明) {String} collection_total 收藏数量
   * @apiSuccess (字段说明) {String} is_approval 是否点赞
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_recommend 是否推荐
   * @apiSuccess (字段说明) {String} create_time 发布时间
   *
   * @apiSampleRequest /api/community/view/{id}
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

      $response->increment('read_total');

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
