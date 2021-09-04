<?php
namespace App\Enum\Module\Education;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-06
 *
 * 课件枚举类
 */
class CoursewareEnum extends BaseEnum
{
  // 课程推荐
  const YES = 1;
  const NO  = 2;

  const WAIT   = 0;
  const FINISH = 1;

  // 课程推荐
  public static $status = [
    self::YES => [
      'value' => self::YES,
      'text' => '是'
    ],

    self::NO => [
      'value' => self::NO,
      'text' => '否'
    ]
  ];


  // 课程推荐
  public static $source = [
    self::YES => [
      'value' => self::YES,
      'text' => '购买'
    ],

    self::NO => [
      'value' => self::NO,
      'text' => '贵宾'
    ]
  ];

  // 课程推荐
  public static $finish = [
    self::WAIT => [
      'value' => self::WAIT,
      'text' => '未完成'
    ],

    self::FINISH => [
      'value' => self::FINISH,
      'text' => '已完成'
    ]
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-24
   * ------------------------------------------
   * 状态值
   * ------------------------------------------
   *
   * 状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::NO];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-24
   * ------------------------------------------
   * 课程来源状态值
   * ------------------------------------------
   *
   * 课程来源状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getSourceStatus($code)
  {
    return self::$status[$code] ?: self::$source[self::YES];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-24
   * ------------------------------------------
   * 状态值
   * ------------------------------------------
   *
   * 状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getFinishStatus($code)
  {
    return self::$finish[$code] ?: self::$finish[self::WAIT];
  }
}
