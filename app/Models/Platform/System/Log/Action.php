<?php
namespace App\Models\Platform\System\Log;

use App\Models\Common\System\Log\Action as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-08
 *
 * 行为日志模型类
 */
class Action extends Common
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-10
   * ------------------------------------------
   * IP地址解析封装
   * ------------------------------------------
   *
   * IP地址解析封装
   *
   * @param [type] $value 长整形ip地址
   * @return [type]
   */
  public function getIpAddressAttribute($value)
  {
    return long2ip($value);
  }
}
