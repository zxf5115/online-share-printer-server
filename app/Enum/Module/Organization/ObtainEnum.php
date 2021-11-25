<?php
namespace App\Enum\Module\Organization;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 机构收益分红枚举类
 */
class ObtainEnum extends BaseEnum
{
  const FINISH = 1; //已确认
  const WAIT   = 2; // 待确认

  // 收益类型封装
  public static $type = [
    self::FINISH => [
      'value' => self::FINISH,
      'text' => '分红'
    ]
  ];

  // 确认状态封装
  public static $confirm = [
    self::FINISH => [
      'value' => self::FINISH,
      'text' => '已确认'
    ],

    self::WAIT => [
      'value' => self::WAIT,
      'text' => '待确认'
    ]
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-24
   * ------------------------------------------
   * 红包类型封装
   * ------------------------------------------
   *
   * 红包类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getTypeStatus($code)
  {
    return self::$type[$code] ?: self::$type[self::FINISH];
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 确认状态封装
   * ------------------------------------------
   *
   * 确认状态封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getConfirmStatus($code)
  {
    return self::$confirm[$code] ?: self::$confirm[self::WAIT];
  }
}
