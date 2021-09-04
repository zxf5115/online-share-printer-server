<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-21
 *
 * 性别枚举类
 */
class SexEnum
{
  // 性别封装
  const UNKOWN  = 0; // 未知
  const MAN     = 1; // 男
  const WOMAN   = 2; // 女
  const SECRECY = 3; // 保密


  // 教育程度封装
  public static $sex = [
    self::UNKOWN       => [
      'value' => self::UNKOWN,
      'text' => '未知'
    ],
    self::MAN       => [
      'value' => self::MAN,
      'text' => '男'
    ],

    self::WOMAN       => [
      'value' => self::WOMAN,
      'text' => '女'
    ],

    self::SECRECY       => [
      'value' => self::SECRECY,
      'text' => '保密'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-21
   * ------------------------------------------
   * 性别类型封装
   * ------------------------------------------
   *
   * 性别类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getSex($code)
  {
    return self::$sex[$code] ?: self::$sex[self::MAN];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-18
   * ------------------------------------------
   * 根据性别信息获取性别代码
   * ------------------------------------------
   *
   * 根据性别信息获取性别代码
   *
   * @param [type] $title 性别信息
   * @return [type]
   */
  public static function getCode($title)
  {
    if('男' == $title)
    {
      return self::MAN;
    }
    else if('女' == $title)
    {
      return self::WOMAN;
    }
    else if('保密' == $title)
    {
      return self::SECRECY;
    }
    else
    {
      return self::UNKOWN;
    }
  }
}
