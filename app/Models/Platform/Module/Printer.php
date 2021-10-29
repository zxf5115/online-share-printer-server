<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Printer as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-04
 *
 * 打印机模型类
 */
class Printer extends Common
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取打印机数量
   * ------------------------------------------
   *
   * 获取打印机数量
   *
   * @param [type] $status 状态
   * @return [type]
   */
  public static function getCountData($status = 0)
  {
    $where = [
      ['status', '<>', '-1']
    ];

    if($status)
    {
      $where = [
        'status' => $status
      ];
    }

    return self::getCount($where);
  }
}
