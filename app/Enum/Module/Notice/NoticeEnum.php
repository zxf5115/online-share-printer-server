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
  const WAIT   = 0; // 待阅读
  const FINISH = 1; // 已完成


  // 通知阅读状态
  public static $finish = [
    self::WAIT       => [
      'value' => self::WAIT,
      'text' => '待阅读'
    ],

    self::FINISH => [
      'value' => self::FINISH,
      'text' => '已完成'
    ],
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 通知类型封装
   * ------------------------------------------
   *
   * 通知类型封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getFinishStatus($code)
  {
    return self::$finish[$code] ?: self::$finish[self::WAIT];
  }
}
