<?php
namespace App\Enum\Module\Member;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-25
 *
 * 会员打印机枚举类
 */
class PrinterEnum extends BaseEnum
{
  // 打印机类型状态
  const OPEN  = 1; // 使用
  const CLOSE = 2; // 未使用

  // 打印机类型封装
  public static $switch = [
    self::OPEN => [
      'value' => self::OPEN,
      'text' => '使用'
    ],

    self::CLOSE => [
      'value' => self::CLOSE,
      'text' => '未使用'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 使用状态封装
   * ------------------------------------------
   *
   * 使用状态封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getUseStatus($code)
  {
    return self::$switch[$code] ?: self::$switch[self::OPEN];
  }
}
