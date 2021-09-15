<?php
namespace App\Http\Controllers\Platform\Module\Printer;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-15
 *
 * 打印机日志控制器类
 */
class LogController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Printer\Log';

  // 客户端搜索字段
  protected $_params = [
    'printer_id',
    'content',
  ];

  // 排序条件
  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对象
  protected $_relevance = [
    'printer'
  ];
}
