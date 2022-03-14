<?php
namespace App\Enum\Module\Inventory;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-20
 *
 * 入库枚举类
 */
class InboundEnum
{
  // 入库类型
  const FRESH   = 1; // 新入库
  const DESTROY = 2; // 损坏入库
  const REPAIR  = 3; // 返修入库


  // 入库类型
  public static $type = [
    self::FRESH       => [
      'value' => self::FRESH,
      'text' => '新入库'
    ],

    self::DESTROY => [
      'value' => self::DESTROY,
      'text' => '损坏入库'
    ],

    self::REPAIR => [
      'value' => self::REPAIR,
      'text' => '返修入库'
    ],
  ];

  // 入库类型
  public static $status = [
    self::FRESH       => [
      'value' => self::FRESH,
      'text' => '预入库'
    ],

    self::DESTROY => [
      'value' => self::DESTROY,
      'text' => '入库盘点'
    ],

    self::REPAIR => [
      'value' => self::REPAIR,
      'text' => '已签收'
    ],
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 库存类型封装
   * ------------------------------------------
   *
   * 库存类型封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getTypeStatus($code)
  {
    return self::$type[$code] ?: self::$type[self::FRESH];
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 入库状态封装
   * ------------------------------------------
   *
   * 入库状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getInboundStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::FRESH];
  }
}
