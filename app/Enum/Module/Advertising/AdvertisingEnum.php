<?php
namespace App\Enum\Module\Advertising;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-07
 *
 * 广告枚举类
 */
class AdvertisingEnum
{
  // 广告链接类型状态
  const COURSE     = 1; // 课程
  const GOODS      = 2; // 商品
  const ACTIVITY   = 3; // 活动
  const INVITATION = 4; // 邀请


  // 广告链接类型状态
  public static $type = [
    self::COURSE       => [
      'value' => self::COURSE,
      'text' => '课程'
    ],

    self::GOODS       => [
      'value' => self::GOODS,
      'text' => '商品'
    ],

    self::ACTIVITY       => [
      'value' => self::ACTIVITY,
      'text' => '活动'
    ],

    self::INVITATION       => [
      'value' => self::INVITATION,
      'text' => '邀请'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-06
   * ------------------------------------------
   * 广告链接类型封装
   * ------------------------------------------
   *
   * 广告链接类型封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getTypeStatus($code)
  {
    return self::$type[$code] ?: self::$type[self::COURSE];
  }
}
