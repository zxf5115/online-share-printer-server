<?php
namespace App\Enum\Module\Inventory;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-20
 *
 * 出库枚举类
 */
class OutboundEnum
{
  // 出库类型
  const FRESH   = 1; // 新设备出库
  const REPAIR  = 2; // 返修出库
  const FINISH  = 3; // 签收


  // 出库类型
  public static $type = [
    self::FRESH       => [
      'value' => self::FRESH,
      'text' => '新设备出库'
    ],

    self::REPAIR => [
      'value' => self::REPAIR,
      'text' => '返修出库'
    ],
  ];

  // 出库状态
  public static $status = [
    self::FRESH       => [
      'value' => self::FRESH,
      'text' => '预出库'
    ],

    self::REPAIR => [
      'value' => self::REPAIR,
      'text' => '配送中'
    ],

    self::FINISH => [
      'value' => self::FINISH,
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
   * 出库状态封装
   * ------------------------------------------
   *
   * 出库状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getOutboundStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::FRESH];
  }
}
