<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-11
 *
 * 库存控制器类
 */
class InventoryController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Inventory';

  // 客户端搜索字段
  protected $_params = [
    'type',
    'equipment_status',
    'create_time',
  ];

  // 关联对象
  protected $_relevance = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 库存摘要
   * ------------------------------------------
   *
   * 库存摘要
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function brief(Request $request)
  {
    try
    {
      $condition = self::getBaseWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $result = $this->_model::getPluck('type', $condition, false, false, true);

      $result = array_column($result, 'value');

      $result = array_count_values($result);

      ksort($result);

      $key = ['printer', 'ink', 'paper'];

      $response = array_combine($key, $result);

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
