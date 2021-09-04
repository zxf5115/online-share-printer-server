<?php
namespace App\Models\Platform\System\Menu;

use App\Models\Common\System\Menu;
use App\Models\Common\System\Menu\MenuCategory as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-16
 *
 * 菜单分类模型类
 */
class MenuCategory extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 获取当前用户可访问的菜单分类数据
   * ------------------------------------------
   *
   * 获取当前用户可访问的菜单分类数据
   *
   * @param [type] $menu_id 菜单编号
   * @return [type]
   */
  public static function getCurrentUserNavigationData($menu_id)
  {
    try
    {
      $result = Menu::whereIn('id', $menu_id)
                    ->where(['parent_id' => 0])
                    ->where(['status' => 1])
                    ->pluck('category_id')
                    ->toArray();

      $category_id = array_unique($result);

      $response = self::whereIn('id', $category_id)
                      ->where(['status' => 1])
                      ->orderBy('sort', 'desc')
                      ->get();

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
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
      $response = [];

      // 获取菜单分类
      $category = self::where(['status' => 1])->get();

      // 菜单分类
      foreach($category as $item)
      {
        // 获取全部菜单
        $response[$item->id] = Menu::with(['navigation' => function($query) use ($menu_id) {
                      $query->whereIn('id', $menu_id)->orderBy('sort', 'DESC');
                    }])
                    ->whereIn('id', $menu_id)
                    ->where(['parent_id' => 0])
                    ->where(['category_id' => $item->id])
                    ->whereIn('type', [1, 3])
                    ->where(['status' => 1])
                    ->orderBy('sort', 'DESC')
                    ->get()
                    ->toArray();
      }

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
