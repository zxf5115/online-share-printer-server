<?php
namespace App\Enum\Module\Inventory;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-20
 *
 * 库存枚举类
 */
class InventoryEnum
{
  // 库存类型
  const PRINTER = 1; // 打印机
  const INK     = 2; // 墨盒
  const PAPER   = 3; // 纸张


  // 库存类型
  public static $type = [
    self::PRINTER       => [
      'value' => self::PRINTER,
      'text' => '打印机'
    ],

    self::INK => [
      'value' => self::INK,
      'text' => '墨盒'
    ],

    self::PAPER => [
      'value' => self::PAPER,
      'text' => '纸张'
    ],
  ];


  // 设备状态
  public static $equipment = [
    self::PRINTER       => [
      'value' => self::PRINTER,
      'text' => '全新'
    ],

    self::INK => [
      'value' => self::INK,
      'text' => '返修'
    ],

    self::PAPER => [
      'value' => self::PAPER,
      'text' => '损坏'
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
    return self::$type[$code] ?: self::$type[self::PRINTER];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 设备状态封装
   * ------------------------------------------
   *
   * 设备状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getEquipmentStatus($code)
  {
    return self::$equipment[$code] ?: self::$equipment[self::PRINTER];
  }

}
