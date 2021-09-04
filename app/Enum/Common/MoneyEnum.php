<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-21
 *
 * 金钱枚举类
 */
class MoneyEnum
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-21
   * ------------------------------------------
   * 时长封装
   * ------------------------------------------
   *
   * 时长封装
   *
   * @param int $value 时间（秒）
   * @return 时长信息
   */
  public static function getTotalMoney($data)
  {
    $total = 0;

    if (empty($data))
    {
      return $total;
    }

    foreach($data as $item)
    {
      $total = bcadd($total, $item, 2);
    }

    return $total;
  }
}
