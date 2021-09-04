<?php
namespace App\Enum\Module\Member;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 会员送货地址枚举类
 */
class AddressEnum extends BaseEnum
{
  // 技能水平状态
  const NONE    = 0; // 不是
  const DEFAULT = 1; // 是

  // 默认地址状态封装
  public static $default = [
    self::NONE => [
      'value' => self::NONE,
      'text' => '不是'
    ],

    self::DEFAULT => [
      'value' => self::DEFAULT,
      'text' => '是'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-24
   * ------------------------------------------
   * 默认地址状态类型封装
   * ------------------------------------------
   *
   * 默认地址状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getIsDefaultStatus($code)
  {
    return self::$default[$code] ?: self::$default[self::NONE];
  }
}
