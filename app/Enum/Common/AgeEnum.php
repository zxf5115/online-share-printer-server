<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-21
 *
 * 年龄枚举类
 */
class AgeEnum
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-18
   * ------------------------------------------
   * 根据出生日期信息获取年龄信息
   * ------------------------------------------
   *
   * 根据出生日期信息获取年龄信息
   *
   * @param [type] $birthday 出生日期
   * @return [type]
   */
  public static function getAge($birthday)
  {
    // 如果生日没有填写
    if(0 == strtotime($birthday))
    {
      return '暂无';
    }

    // 获取间隔多少年
    $age = $birthday->diffInYears();

    if(0 < $age)
    {
      return $age . ' 岁';
    }

    $age = $birthday->diffInMonths();

    if(0 < $age)
    {
      return $age . ' 个月';
    }

    $age = $birthday->diffInWeeks();

    if(0 < $age)
    {
      return $age . ' 周';
    }

    $age = $birthday->diffInDays();

    if(0 < $age)
    {
      return $age . ' 天';
    }

    return '暂无';
  }
}
