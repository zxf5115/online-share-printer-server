<?php
namespace App\Enum\Module\Notice;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-20
 *
 * 通知枚举类
 */
class NoticeEnum
{
  // 通知阅读状态
  const WAIT   = 2; // 待发送
  const FINISH = 1; // 已发送


  // 通知阅读状态
  public static $delivery = [
    self::WAIT       => [
      'value' => self::WAIT,
      'text' => '待发送'
    ],

    self::FINISH => [
      'value' => self::FINISH,
      'text' => '已发送'
    ],
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 通知发送状态封装
   * ------------------------------------------
   *
   * 通知发送状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getDeliveryStatus($code)
  {
    return self::$delivery[$code] ?: self::$delivery[self::WAIT];
  }
}
