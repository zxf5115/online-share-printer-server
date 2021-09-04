<?php
namespace App\Http\Controllers\Api\Module\Currency;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币种类控制器类
 */
class CategoryController extends BaseController
{
  // 模型
  protected $_model = 'App\Models\Api\Module\Currency\Category';

  // 查询条件
  protected $_params = [
    'symbol',
  ];

  // 排序
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @api {get} /api/currency/category/list?page={page} 01. 货币种类列表
   * @apiDescription 获取货币种类分页列表
   * @apiGroup 80. 货币种类模块
   *
   * @apiParam {int} page 当前页数
   * @apiParam {String} symbol 币种符号
   *
   * @apiSuccess (字段说明) {Number} id 货币种类编号
   * @apiSuccess (字段说明) {String} slug 币种名称
   * @apiSuccess (字段说明) {String} symbol 币种符号
   * @apiSuccess (字段说明) {String} fullname 币种全称
   * @apiSuccess (字段说明) {String} logo_url 图标链接
   * @apiSuccess (字段说明) {String} market_cap_usd 币种市值
   * @apiSuccess (字段说明) {String} available_supply 流通量
   * @apiSuccess (字段说明) {String} total_supply 发行总量
   * @apiSuccess (字段说明) {String} max_supply 最大发行量
   * @apiSuccess (字段说明) {String} issue_time 上市时间
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_main 是否主流
   * @apiSuccess (字段说明) {String} is_defi 是否DeFi
   *
   * @apiSampleRequest /api/currency/category/list
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
   * @api {get} /api/currency/category/select 02. 货币种类数据
   * @apiDescription 获取货币种类不分页数据列表
   * @apiGroup 80. 货币种类模块
   *
   * @apiParam {String} total 显示数量(默认显示20个)
   *
   * @apiSuccess (字段说明) {Number} id 货币种类编号
   * @apiSuccess (字段说明) {String} slug 币种名称
   * @apiSuccess (字段说明) {String} symbol 币种符号
   * @apiSuccess (字段说明) {String} fullname 币种全称
   * @apiSuccess (字段说明) {String} logo_url 图标链接
   * @apiSuccess (字段说明) {String} market_cap_usd 币种市值
   * @apiSuccess (字段说明) {String} available_supply 流通量
   * @apiSuccess (字段说明) {String} total_supply 发行总量
   * @apiSuccess (字段说明) {String} max_supply 最大发行量
   * @apiSuccess (字段说明) {String} issue_time 上市时间
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_main 是否主流
   * @apiSuccess (字段说明) {String} is_defi 是否DeFi
   *
   * @apiSampleRequest /api/currency/category/select
   * @apiVersion 1.0.0
   */
  public function select(Request $request)
  {
    try
    {
      $total = $request->total ?? 20;

      $condition = self::getSimpleWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'select');

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
   * @api {get} /api/currency/category/hot 03. 热门货币种类
   * @apiDescription 获取热门货币种类数据
   * @apiGroup 80. 货币种类模块
   *
   * @apiParam {int} total 显示数量，默认显示8个
   *
   * @apiSuccess (字段说明) {Number} id 货币种类编号
   * @apiSuccess (字段说明) {String} slug 币种名称
   * @apiSuccess (字段说明) {String} symbol 币种符号
   * @apiSuccess (字段说明) {String} fullname 币种全称
   * @apiSuccess (字段说明) {String} logo_url 图标链接
   * @apiSuccess (字段说明) {String} market_cap_usd 币种市值
   * @apiSuccess (字段说明) {String} available_supply 流通量
   * @apiSuccess (字段说明) {String} total_supply 发行总量
   * @apiSuccess (字段说明) {String} max_supply 最大发行量
   * @apiSuccess (字段说明) {String} issue_time 上市时间
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_main 是否主流
   * @apiSuccess (字段说明) {String} is_defi 是否DeFi
   * @apiSuccess (字段说明) {Array} api 第三方接口数据
   *
   * @apiSampleRequest /api/currency/category/hot
   * @apiVersion 1.0.0
   */
  public function hot(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData(1, 'is_hot');

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $total = $request->total ?? 8;

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'hot');

      $response = $this->_model::getList($condition, $relevance, $this->_order, true, $total);

      if(!empty($response))
      {
        $slug = array_column($response, 'slug');

        $slug = implode(',', $slug);

        $result = $this->_model::getData($slug);

        if(is_array($result))
        {
          foreach($response as $key => &$item)
          {
            $item['api'] = $result[$key];
          }
        }
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
   * @api {get} /api/currency/category/main 04. 主流货币种类
   * @apiDescription 获取主流货币种类数据
   * @apiGroup 80. 货币种类模块
   *
   * @apiParam {int} total 显示数量，默认显示8个
   *
   * @apiSuccess (字段说明) {Number} id 货币种类编号
   * @apiSuccess (字段说明) {String} slug 币种名称
   * @apiSuccess (字段说明) {String} symbol 币种符号
   * @apiSuccess (字段说明) {String} fullname 币种全称
   * @apiSuccess (字段说明) {String} logo_url 图标链接
   * @apiSuccess (字段说明) {String} market_cap_usd 币种市值
   * @apiSuccess (字段说明) {String} available_supply 流通量
   * @apiSuccess (字段说明) {String} total_supply 发行总量
   * @apiSuccess (字段说明) {String} max_supply 最大发行量
   * @apiSuccess (字段说明) {String} issue_time 上市时间
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_main 是否主流
   * @apiSuccess (字段说明) {String} is_defi 是否DeFi
   * @apiSuccess (字段说明) {Array} api 第三方接口数据
   *
   * @apiSampleRequest /api/currency/category/main
   * @apiVersion 1.0.0
   */
  public function main(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData(1, 'is_main');

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $total = $request->total ?? 8;

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'main');

      $response = $this->_model::getList($condition, $relevance, $this->_order, true, $total);

      if(!empty($response))
      {
        $slug = array_column($response, 'slug');

        $slug = implode(',', $slug);

        $result = $this->_model::getData($slug);

        if(is_array($result))
        {
          foreach($response as $key => &$item)
          {
            $item['api'] = $result[$key];
          }
        }
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
   * @api {get} /api/currency/category/defi 05. DeFi货币种类
   * @apiDescription 获取主流货币种类数据
   * @apiGroup 80. 货币种类模块
   *
   * @apiParam {int} total 显示数量，默认显示24个
   *
   * @apiSuccess (字段说明) {Number} id 货币种类编号
   * @apiSuccess (字段说明) {String} slug 币种名称
   * @apiSuccess (字段说明) {String} symbol 币种符号
   * @apiSuccess (字段说明) {String} fullname 币种全称
   * @apiSuccess (字段说明) {String} logo_url 图标链接
   * @apiSuccess (字段说明) {String} market_cap_usd 币种市值
   * @apiSuccess (字段说明) {String} available_supply 流通量
   * @apiSuccess (字段说明) {String} total_supply 发行总量
   * @apiSuccess (字段说明) {String} max_supply 最大发行量
   * @apiSuccess (字段说明) {String} issue_time 上市时间
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_main 是否主流
   * @apiSuccess (字段说明) {String} is_defi 是否DeFi
   * @apiSuccess (字段说明) {Array} api 第三方接口数据
   *
   * @apiSampleRequest /api/currency/category/defi
   * @apiVersion 1.0.0
   */
  public function defi(Request $request)
  {
    try
    {
      $condition = self::getSimpleWhereData(1, 'is_defi');

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $total = $request->total ?? 24;

      // 获取关联对象
      $response = $this->_model::getList($condition, $relevance, $this->_order, true, $total);

      if(!empty($response))
      {
        $slug = array_column($response, 'slug');

        $slug = implode(',', $slug);

        $result = $this->_model::getData($slug);

        if(is_array($result))
        {
          foreach($response as $key => &$item)
          {
            $item['api'] = $result[$key];
          }
        }
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
   * @api {get} /api/currency/category/view/{id} 05. 货币种类详情
   * @apiDescription 获取货币种类详情
   * @apiGroup 80. 货币种类模块
   *
   * @apiSuccess (字段说明) {Number} id 货币种类编号
   * @apiSuccess (字段说明) {String} slug 币种名称
   * @apiSuccess (字段说明) {String} symbol 币种符号
   * @apiSuccess (字段说明) {String} fullname 币种全称
   * @apiSuccess (字段说明) {String} logo_url 图标链接
   * @apiSuccess (字段说明) {String} market_cap_usd 币种市值
   * @apiSuccess (字段说明) {String} available_supply 流通量
   * @apiSuccess (字段说明) {String} total_supply 发行总量
   * @apiSuccess (字段说明) {String} max_supply 最大发行量
   * @apiSuccess (字段说明) {String} issue_time 上市时间
   * @apiSuccess (字段说明) {String} is_hot 是否热门
   * @apiSuccess (字段说明) {String} is_main 是否主流
   * @apiSuccess (字段说明) {String} is_defi 是否DeFi
   *
   * @apiSampleRequest /api/currency/category/view/{id}
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
