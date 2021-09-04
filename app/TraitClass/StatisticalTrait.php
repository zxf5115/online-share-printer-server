<?php
namespace App\TraitClass;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-30
 *
 * 统计特征
 */
trait StatisticalTrait
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取统计时间区间
   * ------------------------------------------
   *
   * 获取统计时间区间
   *
   * @param integer $type 今日、昨天、最近七日、最近一个月、最近三个月、最近半年、最近一年
   * @return [type]
   */
  public static function getWhereCondition($type = 1)
  {
    $response = [];











    // 今天0点
    if(1 == $type)
    {
      $timestamp = strtotime(date("Y-m-d"), time());

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    // 昨天0点
    else if(2 == $type)
    {
      $timestamp = strtotime(date("Y-m-d", strtotime('-1 day')));

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    // 近7天
    else if(3 == $type)
    {
      $timestamp = strtotime(date("Y-m-d", strtotime('-7 day')));

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    // 近一月
    else if(4 == $type)
    {
      // 三个月前
      $timestamp = strtotime(date("Y-m-d", strtotime('-1 month')));

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    // 近三月
    else if(5 == $type)
    {
      $timestamp = strtotime(date("Y-m-d", strtotime('-3 month')));

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    // 近六月
    else if(6 == $type)
    {
      $timestamp = strtotime(date("Y-m-d", strtotime('-6 month')));

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    // 近一年
    else if(7 == $type)
    {
      $timestamp = strtotime(date("Y-m-d", strtotime('-1 year')));

      $response = [
        'status' => 1,
        ['create_time', '>', $timestamp]
      ];
    }
    else
    {
      $response = [
        'status' => 1
      ];
    }

    return $response;
  }
}
