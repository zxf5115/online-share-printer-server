<?php
namespace App\TraitClass;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-22
 *
 * 工具特征
 */
trait ToolTrait
{
  protected static $complete_name = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-22
   * ------------------------------------------
   * 获取课程单元目录信息
   * ------------------------------------------
   *
   * 获取课程单元目录信息
   *
   * @param [type] $data [description]
   * @return [type]
   */
  public static function getUnitDirectory($data, &$response)
  {
    foreach($data as $k => $item)
    {
      $response[$k] = $item->title;

      if(empty($item->children))
      {
        continue;
      }

      self::getUnitDirectory($item, $response[$k]);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 将结果集按照指定字段进行分组
   * ------------------------------------------
   *
   * 将结果集按照指定字段进行分组
   *
   * @return [type]
   */
  public static function allocation($data, $field)
  {
    $response = [];

    $result = [];

    if(empty($data['data']))
    {
      return $data;
    }

    $allocation = array_column($data['data'], $field);

    foreach($data['data'] as $k => $item)
    {
      if(false !== $key = array_search($item[$field], $allocation))
      {
        $result[$key][] = $item;
      }
    }

    foreach($result as $k => $item)
    {
      $response[$k]['time'] = $allocation[$k];
      $response[$k]['data'] = $item;
    }

    $response = array_values($response);

    $data['data'] = $response;

    return $data;
  }
}
