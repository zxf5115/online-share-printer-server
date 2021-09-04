<?php
namespace App\Enum\Module\Member;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 会员设置枚举类
 */
class SettingEnum extends BaseEnum
{
  // 设置类型状态
  const OPEN  = 1; // 推送
  const CLOSE = 2; // 不退缩

  // 设置类型封装
  public static $switch = [
    self::OPEN => [
      'value' => self::OPEN,
      'text' => '推送'
    ],

    self::CLOSE => [
      'value' => self::CLOSE,
      'text' => '不退缩'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-11
   * ------------------------------------------
   * 开关类型封装
   * ------------------------------------------
   *
   * 开关类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getSwitchStatus($code)
  {
    return self::$switch[$code] ?: self::$switch[self::OPEN];
  }
}
