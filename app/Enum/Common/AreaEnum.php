<?php
namespace App\Enum\Common;

use App\Models\Common\Module\Common\Area;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-21
 *
 * 地区枚举类
 */
class AreaEnum
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-21
   * ------------------------------------------
   * 地区封装
   * ------------------------------------------
   *
   * 地区封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getArea($code)
  {
    $default = [
      'value' => '',
      'text'  => ''
    ];

    if(empty($code))
    {
      return $default;
    }

    $response = Area::getRow(['id' => $code]);

    $title = $response->title ?? '';

    return [
      'value' => $code,
      'text'  => $title
    ];
  }
}
