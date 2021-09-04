<?php
namespace App\Http\Constant;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-05
 *
 * 状态常量类
 */
class Status
{
  const ENABLE  =  1; // 启用
  const DISABLE =  2; // 禁用
  const DELETE  = -1; // 删除

  public static $status = [
    self::ENABLE  => '启用',
    self::DISABLE => '禁用',
    self::DELETE  => '删除',
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 组装Code对应显示内容
   * ------------------------------------------
   *
   * 组装Code对应显示内容
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function status($code)
  {
    return self::$status[$code] ?: self::$status[self::ENABLE];
  }


  // -----------------------------------------------------------------------


  const MESSAGE_NOTICE       = 1; // 通知
  const MESSAGE_BACKLOG      = 2; // 待办
  const MESSAGE_ANNOUNCEMENT = 3; // 公告
  const MESSAGE_WARNING      = 4; // 预警

  public static $message = [
    self::MESSAGE_NOTICE       => '通知',
    self::MESSAGE_BACKLOG      => '待办',
    self::MESSAGE_ANNOUNCEMENT => '公告',
    self::MESSAGE_WARNING      => '预警',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 组装Code对应显示内容
   * ------------------------------------------
   *
   * 组装Code对应显示内容
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function message($code)
  {
    return self::$message[$code] ?: self::$message[self::MESSAGE_NOTICE];
  }


  // -----------------------------------------------------------------------


  const MENU_TYPE_MENU        = 1; // 菜单
  const MENU_TYPE_BUTTON      = 2; // 按钮
  const MENU_TYPE_MENU_BUTTON = 3; // 菜单|按钮

  public static $menuType = [
    self::MENU_TYPE_MENU        => '菜单',
    self::MENU_TYPE_BUTTON      => '按钮',
    self::MENU_TYPE_MENU_BUTTON => '菜单|按钮',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 组装Code对应显示内容
   * ------------------------------------------
   *
   * 组装Code对应显示内容
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function menuType($code)
  {
    return self::$menuType[$code] ?: self::$menuType[self::MENU_TYPE_MENU];
  }


  // -----------------------------------------------------------------------


  const MESSAGE_UNREAD = 1; // 未读
  const MESSAGE_READED = 2; // 已读
  const MESSAGE_DELETE = 3; // 删除

  public static $messageStatus = [
    self::MESSAGE_UNREAD => '未读',
    self::MESSAGE_READED => '已读',
    self::MESSAGE_DELETE => '删除',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 组装Code对应显示内容
   * ------------------------------------------
   *
   * 组装Code对应显示内容
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function messageStatus($code)
  {
    return self::$messageStatus[$code] ?: self::$messageStatus[self::MESSAGE_UNREAD];
  }






  // -----------------------------------------------------------------------


  const STORE_UNOPEN = 0; // 待审核
  const STORE_OPEN = 1; // 开启
  const MESSAGE_CLOSE = 2; // 关闭

  public static $storeCloseStatus = [
    self::STORE_UNOPEN       => [
      'value' => self::STORE_UNOPEN,
      'text' => '待审核'
    ],

    self::STORE_OPEN       => [
      'value' => self::STORE_OPEN,
      'text' => '开启'
    ],

    self::MESSAGE_CLOSE       => [
      'value' => self::MESSAGE_CLOSE,
      'text' => '关闭'
    ],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 组装Code对应显示内容
   * ------------------------------------------
   *
   * 组装Code对应显示内容
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function storeCloseStatus($code)
  {
    return self::$storeCloseStatus[$code] ?: self::$storeCloseStatus[self::STORE_UNAUDIT];
  }



  const STORE_UNAUDIT = 0; // 待审核
  const STORE_AUDIT = 1; // 审核通过
  const MESSAGE_AUDIT_ERROR = 2; // 审核未通过

  public static $storeAuditStatus = [
    self::STORE_UNAUDIT       => [
      'value' => self::STORE_UNAUDIT,
      'text' => '待审核'
    ],

    self::STORE_AUDIT       => [
      'value' => self::STORE_AUDIT,
      'text' => '审核通过'
    ],

    self::MESSAGE_AUDIT_ERROR       => [
      'value' => self::MESSAGE_AUDIT_ERROR,
      'text' => '审核未通过'
    ],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 组装Code对应显示内容
   * ------------------------------------------
   *
   * 组装Code对应显示内容
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function storeAuditStatus($code)
  {
    return self::$storeAuditStatus[$code] ?: self::$storeAuditStatus[self::STORE_UNAUDIT];
  }
}
