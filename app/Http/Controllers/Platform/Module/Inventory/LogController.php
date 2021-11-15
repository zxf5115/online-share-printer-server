<?php
namespace App\Http\Controllers\Platform\Module\Inventory;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-11
 *
 * 库存日志控制器类
 */
class LogController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Inventory\Log';

  // 客户端搜索字段
  protected $_params = [
    'inventory_id',
    'operator',
    'create_time',
  ];
}
