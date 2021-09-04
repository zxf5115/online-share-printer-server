<?php
namespace App\Http\Controllers\Api\Module\Common;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 全国区域控制器类
 */
class AreaController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Common\Module\Common\Area';

  // 默认查询条件
  protected $_where = [
    'parent_id' => 0
  ];

  // 客户端搜索字段
  protected $_params = [
    'id',
    'parent_id'
  ];

  // 排序方式
  protected $_order = [
    ['key' => 'id', 'value' => 'asc'],
  ];


  /**
   * @api {get} /api/common/area/list 02. 地区列表
   * @apiDescription 获取全国地区列表
   * @apiGroup 02. 公共模块
   *
   * @apiParam {string} parent_id 上级地区编号（为空：获取省，省编号: 获取市，市编号: 获取县）
   *
   * @apiSampleRequest /api/common/area/list
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

      $response = $this->_model::getList($condition, $this->_relevance, $this->_order);

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
