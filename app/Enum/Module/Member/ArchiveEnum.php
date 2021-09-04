<?php
namespace App\Enum\Module\Member;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-09-25
 *
 * 会员档案枚举类
 */
class ArchiveEnum extends BaseEnum
{
  // 技能水平状态
  const NONE     = 0; // 无基础
  const ONE_DOWN = 1; // 一年以下
  const ONE_ON   = 2; // 一年以上

  // 技能水平状态封装
  public static $level = [
    self::NONE => [
      'value' => self::NONE,
      'text' => '无基础'
    ],

    self::ONE_DOWN => [
      'value' => self::ONE_DOWN,
      'text' => '一年以下'
    ],

    self::ONE_ON => [
      'value' => self::ONE_ON,
      'text' => '一年以上'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
   * ------------------------------------------
   * 技能水平状态类型封装
   * ------------------------------------------
   *
   * 技能水平状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getSkillLevelStatus($code)
  {
    return self::$level[$code] ?: self::$level[self::NONE];
  }
}
