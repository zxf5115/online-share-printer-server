<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-09-25
 *
 * 教育枚举类
 */
class EducationEnum
{
  // 状态封装
  const SMAILL     = 1; // 小学
  const JUNIOR     = 2; // 初中
  const HIGH       = 3; // 高中
  const UNIVERSITY = 4; // 大学
  const GRADUATE   = 5; // 研究生
  const MASTER     = 6; // 硕士
  const DOCTOR     = 7; // 博士


  // 教育程度封装
  public static $degree = [
    self::SMAILL       => [
      'value' => self::SMAILL,
      'text' => '小学'
    ],

    self::JUNIOR       => [
      'value' => self::JUNIOR,
      'text' => '初中'
    ],

    self::HIGH       => [
      'value' => self::HIGH,
      'text' => '高中'
    ],

    self::UNIVERSITY       => [
      'value' => self::UNIVERSITY,
      'text' => '大学'
    ],

    self::GRADUATE       => [
      'value' => self::GRADUATE,
      'text' => '研究生'
    ],

    self::MASTER       => [
      'value' => self::MASTER,
      'text' => '硕士'
    ],

    self::DOCTOR       => [
      'value' => self::DOCTOR,
      'text' => '博士'
    ],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-25
   * ------------------------------------------
   * 教育程度类型封装
   * ------------------------------------------
   *
   * 教育程度类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getDegree($code)
  {
    return self::$degree[$code] ?: self::$degree[self::UNIVERSITY];
  }
}
