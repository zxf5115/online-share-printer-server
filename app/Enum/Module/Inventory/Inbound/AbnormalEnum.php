<?php
namespace App\Enum\Module\Inventory\Inbound;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-23
 *
 * 入库异常枚举类
 */
class AbnormalEnum
{
  // 异常类型
  const MANUFACTURER = 1; // 厂家异常
  const WAREHOUSE    = 2; // 库房异常


  // 异常类型
  public static $type = [
    self::MANUFACTURER => [
      'value' => self::MANUFACTURER,
      'text' => '厂家异常'
    ],

    self::WAREHOUSE => [
      'value' => self::WAREHOUSE,
      'text' => '库房异常'
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
    return self::$type[$code] ?: self::$type[self::MANUFACTURER];
  }
}
