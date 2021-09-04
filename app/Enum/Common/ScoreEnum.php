<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-21
 *
 * 分数枚举类
 */
class ScoreEnum
{
  // 性别封装
  const POTIMAL    = 1; // 优
  const GOOD       = 2; // 良
  const MEDIOCRITY = 3; // 中
  const POOR       = 4; // 差
  const NONE       = 5; // 无


  // 分数封装
  public static $score = [
    self::POTIMAL       => [
      'value' => self::POTIMAL,
      'text' => '优'
    ],

    self::GOOD       => [
      'value' => self::GOOD,
      'text' => '良'
    ],

    self::MEDIOCRITY       => [
      'value' => self::MEDIOCRITY,
      'text' => '中'
    ],

    self::POOR       => [
      'value' => self::POOR,
      'text' => '差'
    ],

    self::NONE       => [
      'value' => self::NONE,
      'text' => '无'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-21
   * ------------------------------------------
   * 分数类型封装
   * ------------------------------------------
   *
   * 分数类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getScore($code)
  {
    return self::$score[$code] ?: self::$score[self::POTIMAL];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-11-21
   * ------------------------------------------
   * 根据分数获取评级
   * ------------------------------------------
   *
   * 根据分数获取评级
   *
   * @param [type] $score 分数
   * @return [type]
   */
  public static function getCodeScore($score)
  {
    if($score > 84)
    {
      return self::getScore(self::POTIMAL);
    }
    else if($score > 74)
    {
      return self::getScore(self::GOOD);
    }
    else if($score > 59)
    {
      return self::getScore(self::MEDIOCRITY);
    }
    else if($score > 1)
    {
      return self::getScore(self::POOR);
    }
    else
    {
      return self::getScore(self::NONE);
    }
  }
}
