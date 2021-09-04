<?php
namespace App\Http\Controllers\Api\Module\Advertising;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

class PositionController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Advertising\Position';

  // 关联对象
  protected $_relevance = [
    'select' => false,
    'view' => [
      'advertising'
    ]
  ];


  /**
   * @api {get} /api/advertising/position/select 01. 广告位数据
   * @apiDescription 获取广告位不分页列表数据
   * @apiGroup 04. 广告位模块
   *
   * @apiSuccess (响应|广告位) {Number} id 广告位编号
   * @apiSuccess (响应|广告位) {Number} title 广告位名称
   *
   * @apiSampleRequest /api/advertising/position/select
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
   * @api {get} /api/advertising/position/view/{id} 02. 广告位详情
   * @apiDescription 获取广告位详情
   * @apiGroup 04. 广告位模块
   *
   * @apiSuccess (响应|广告位) {Number} id 广告位编号
   * @apiSuccess (响应|广告位) {Number} title 广告位名称
   * @apiSuccess (响应|广告) {String} title 广告标题
   * @apiSuccess (响应|广告) {String} picture 广告图片
   * @apiSuccess (响应|广告) {String} link 广告链接
   *
   * @apiSampleRequest /api/advertising/position/view/{id}
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
