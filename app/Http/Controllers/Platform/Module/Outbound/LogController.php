<?php
namespace App\Http\Controllers\Platform\Module\Outbound;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-03-17
 *
 * 出库日志控制器类
 */
class LogController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Outbound\Log';

  // 客户端搜索字段
  protected $_params = [
    'code',
    'model',
    'outbound_id',
  ];

  // 关联对象
  protected $_relevance = [
    'outbound'
  ];
}
