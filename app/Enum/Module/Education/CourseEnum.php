<?php
namespace App\Enum\Module\Education;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-22
 *
 * 课程枚举类
 */
class CourseEnum extends BaseEnum
{
  // 报名状态
  const APPLY = 1;
  const OPEN = 2;


  // 报名状态
  public static $status = [
    self::APPLY => [
      'value' => self::APPLY,
      'text' => '报名中'
    ],

    self::OPEN => [
      'value' => self::OPEN,
      'text' => '已开课'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-24
   * ------------------------------------------
   * 报名状态状态值
   * ------------------------------------------
   *
   * 报名状态状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getApplyStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::APPLY];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-24
   * ------------------------------------------
   * 课程周期封装
   * ------------------------------------------
   *
   * 课程周期封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getSemesterData($code)
  {
    return [
      'value' => $code,
      'text' => '第'.$code.'期'
    ];
  }
}
