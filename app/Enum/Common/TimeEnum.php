<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 时间枚举类
 */
class TimeEnum
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 格式化日期时间
   * ------------------------------------------
   *
   * 格式化日期时间
   *
   * @param int $value 时间（秒）
   * @return 时长信息
   */
  public static function formatDateTime($value)
  {
    if (empty($value))
    {
      return '暂无';
    }

    $timestamp = time() - $value;

    if(60 > $timestamp)
    {
      return '刚刚';
    }

    if(3600 > $timestamp)
    {
      $minutes = floor($timestamp / 60);

      return $minutes . ' 分钟前 ';
    }

    if(86400 > $timestamp)
    {
      $hour = floor($timestamp / 3600);

      return $hour . ' 小时前 ';
    }

    return date('Y-m-d', $value);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-21
   * ------------------------------------------
   * 计算天数封装
   * ------------------------------------------
   *
   * 计算天数封装
   *
   * @param int $value 时间（秒）
   * @return 时长信息
   */
  public static function getDayNumber($value)
  {
    if (empty($value))
    {
      return '0 天 ';
    }

    $day = floor($value / (3600 * 24));

    $day = $day > 0 ? $day . ' 天 ' : '0 天 ';

    return $day;
  }


  // 日期时间封装
  public static function getDateTime($value)
  {
    $text = '0';

    if(0 != $value)
    {
      $text = date('Y-m-d H:i:s', $value);
    }

    return [
      'text' => $text,
      'value' => $value,
    ];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 格式化星期
   * ------------------------------------------
   *
   * 格式化星期
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public static function formatWeek($value)
  {
    $week = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];

    $timestamp = date('w', $value);

    return $week[$timestamp];
  }
}
