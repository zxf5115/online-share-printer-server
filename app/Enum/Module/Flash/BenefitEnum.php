<?php
namespace App\Enum\Module\Flash;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-22
 *
 * 投诉枚举类
 */
class BenefitEnum extends BaseEnum
{
  // 快讯利益
  const MORE = 1;
  const LESS = 2;


  // 快讯利益
  public static $status = [
    self::MORE => [
      'value' => self::MORE,
      'text' => '利多'
    ],

    self::LESS => [
      'value' => self::LESS,
      'text' => '利空'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 快讯利益状态值
   * ------------------------------------------
   *
   * 快讯利益状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::MORE];
  }
}
