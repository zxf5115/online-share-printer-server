<?php
namespace App\Enum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-20
 *
 * 消息枚举类
 */
class MessageEnum
{
  // 菜单分类状态
  const NOTICE       = 1; // 通知
  const TODO         = 2; // 待办
  const ANNOUNCEMENT = 3; // 公告
  const WARNING      = 4; // 预警


  // 消息阅读状态
  const UNREAD = 1; // 未读
  const READED = 2; // 已读
  const DELETE = 3; // 删除


  // 分类状态
  public static $type = [
    self::NOTICE       => [
      'value' => self::NOTICE,
      'text' => '通知'
    ],

    self::TODO       => [
      'value' => self::TODO,
      'text' => '待办'
    ],

    self::ANNOUNCEMENT => [
      'value' => self::ANNOUNCEMENT,
      'text' => '公告'
    ],

    self::WARNING => [
      'value' => self::WARNING,
      'text' => '预警'
    ],
  ];


  // 消息阅读状态
  public static $read = [
    self::UNREAD => [
      'value' => self::UNREAD,
      'text' => '未读'
    ],

    self::READED => [
      'value' => self::READED,
      'text' => '已读'
    ],

    self::DELETE => [
      'value' => self::DELETE,
      'text' => '删除'
    ],
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 消息类型封装
   * ------------------------------------------
   *
   * 消息类型封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getTypeStatus($code)
  {
    return self::$type[$code] ?: self::$type[self::NOTICE];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-22
   * ------------------------------------------
   * 消息文本数组封装
   * ------------------------------------------
   *
   * 消息文本数组封装
   *
   * @return [type]
   */
  public static function getTypeText()
  {
    return [
      self::NOTICE       => '通知',
      self::TODO         => '待办',
      self::ANNOUNCEMENT => '公告',
      self::WARNING      => '预警'
    ];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 消息阅读状态状态封装
   * ------------------------------------------
   *
   * 工资生成状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getReadStatus($code)
  {
    return self::$read[$code] ?: self::$read[self::UNREAD];
  }
}
