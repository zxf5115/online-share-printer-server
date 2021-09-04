<?php
namespace App\Enum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-20
 *
 * 菜单枚举类
 */
class MenuEnum
{
  // 菜单分类状态
  const PLATFORM = 1; // 平台
  const ORGAN    = 2; // 机构
  const ALL      = 3; // 平台|机构


  // 菜单类型状态
  const MENU            = 1; // 菜单
  const BUTTON          = 2; // 按钮


  // 菜单类型
  public static $type = [
    self::MENU       => [
      'value' => self::MENU,
      'text' => '菜单'
    ],

    self::BUTTON       => [
      'value' => self::BUTTON,
      'text' => '按钮'
    ],

    self::ALL => [
      'value' => self::ALL,
      'text' => '菜单|按钮'
    ]
  ];


  // 分类状态
  public static $category = [
    self::PLATFORM       => [
      'value' => self::PLATFORM,
      'text' => '平台'
    ],

    self::ORGAN       => [
      'value' => self::ORGAN,
      'text' => '机构'
    ],

    self::ALL => [
      'value' => self::ALL,
      'text' => '平台|机构'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 菜单分类状态封装
   * ------------------------------------------
   *
   * 菜单分类状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getCategoryStatus($code)
  {
    return self::$category[$code] ?: self::$category[self::PLATFORM];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-05
   * ------------------------------------------
   * 菜单类型状态封装
   * ------------------------------------------
   *
   * 菜单类型状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getTypeStatus($code)
  {
    return self::$type[$code] ?: self::$type[self::MENU];
  }
}
