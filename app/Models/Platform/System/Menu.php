<?php
namespace App\Models\Platform\System;

use Illuminate\Support\Facades\Redis;
use App\Models\Common\System\Menu as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-05
 *
 * 菜单模型类
 */
class Menu extends Common
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-20
   * ------------------------------------------
   * 获取当前用户可访问的菜单数据
   * ------------------------------------------
   *
   * 获取当前用户可访问的菜单数据
   *
   * @param [type] $menu_id 菜单编号
   * @return [type]
   */
  public static function getCurrentUserMenuData($menu_id)
  {
    try
    {
      $menu = self::with(['navigation' => function($query) use ($menu_id) {
                    $query->whereIn('id', $menu_id)->orderBy('sort', 'DESC');
                  }])
                  ->whereIn('id', $menu_id)
                  ->where(['parent_id' => 0])
                  ->whereIn('type', [1, 3])
                  ->where(['status' => 1])
                  ->orderBy('sort', 'DESC')
                  ->get()
                  ->toArray();

      $button = self::whereIn('id', $menu_id)
                    ->whereIn('type', [2, 3])
                    ->where(['status' => 1])
                    ->orderBy('sort')
                    ->get()
                    ->toArray();

      $button = array_column($button, 'url');

      $button = array_map(function($item) {
        return str_replace('/', ':', $item);
      }, $button);

      return ['menu' => $menu, 'button' => $button];
    }
    catch(\Exception $e)
    {
      self::log($e);

      return false;
    }
  }
}
