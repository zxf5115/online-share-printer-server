<?php
namespace App\Enum\Module\Advertising;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-07
 *
 * 广告位枚举类
 */
class PositionEnum
{
  // 广告位启用状态
  const OPEN  = 1; // 开启
  const CLOSE = 2; // 未开启


  // 广告位启用状态
  public static $open = [
    self::OPEN       => [
      'value' => self::OPEN,
      'text' => '开启'
    ],

    self::CLOSE       => [
      'value' => self::CLOSE,
      'text' => '关闭'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-06
   * ------------------------------------------
   * 广告位启用状态封装
   * ------------------------------------------
   *
   * 广告位启用状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getIsOpenStatus($code)
  {
    return self::$open[$code] ?: self::$open[self::OPEN];
  }
}
