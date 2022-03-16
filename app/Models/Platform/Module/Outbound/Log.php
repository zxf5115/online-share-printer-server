<?php
namespace App\Models\Platform\Module\Outbound;

use App\Models\Common\Module\Outbound\Log as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-03-15
 *
 * 出库日志模型类
 */
class Log extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-03-15
   * ------------------------------------------
   * 记录出库日志
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param [type] $outbound_id 出库编号
   * @param [type] $model 设备型号
   * @param [type] $code 设备编号
   * @param [type] $message 日志内容
   * @return [type]
   */
  public static function gather($outbound_id, $model, $code, $message)
  {
    try
    {
      $log = new Log();

      $log->outbound_id = $outbound_id;
      $log->model = $model;
      $log->code = $code;
      $log->content = $message;
      $log->save();

      return true;
    }
    catch(\Exception $e)
    {
      return false;
    }
  }
}
