<?php
namespace App\Models\Platform\Module\Printer;

use App\Models\Common\Module\Printer\Log as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-15s
 *
 * 报修分类模型类
 */
class Log extends Common
{


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-15
   * ------------------------------------------
   * 打印机日志与打印机关联函数
   * ------------------------------------------
   *
   * 打印机日志与打印机关联函数
   *
   * @return [type]
   */
  public function printer()
  {
    return $this->belongsTo(
      'App\Models\Platform\Module\Printer',
      'printer_id',
      'id'
    );
  }
}
