<?php
namespace App\Enum\Module\Printer;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-04
 *
 * 打印机枚举类
 */
class PrinterEnum extends BaseEnum
{
  // 机器状态
  const ONLINE  = 1;
  const OFFLINE = 2;

  // 阅读状态
  public static $status = [
    self::ONLINE => [
      'value' => self::ONLINE,
      'text' => '在线'
    ],

    self::OFFLINE => [
      'value' => self::OFFLINE,
      'text' => '离线'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 机器状态状态值
   * ------------------------------------------
   *
   * 机器状态状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::ONLINE];
  }
}
