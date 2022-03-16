<?php
namespace App\Models\Platform\Module\Inbound;

use App\Models\Common\Module\Inbound\Log as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-03-15
 *
 * 入库日志模型类
 */
class Log extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-03-16
   * ------------------------------------------
   * 记录入库日志
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param [type] $inbound_id 入库编号
   * @param [type] $model 设备型号
   * @param [type] $code 设备编号
   * @param [type] $message 日志内容
   * @return [type]
   */
  public static function gather($inbound_id, $model, $code, $message)
  {
    try
    {
      $log = new Log();

      $log->inbound_id = $inbound_id;
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
