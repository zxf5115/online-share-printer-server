<?php
namespace App\Enum\Module\Complain;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-22
 *
 * 投诉枚举类
 */
class ComplainEnum extends BaseEnum
{
  // 阅读状态
  const UNREAD = 0;
  const READED = 1;


  // 阅读状态
  public static $status = [
    self::UNREAD => [
      'value' => self::UNREAD,
      'text' => '未读'
    ],

    self::READED => [
      'value' => self::READED,
      'text' => '已读'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-24
   * ------------------------------------------
   * 阅读状态状态值
   * ------------------------------------------
   *
   * 阅读状态状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getReadStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::UNREAD];
  }
}
