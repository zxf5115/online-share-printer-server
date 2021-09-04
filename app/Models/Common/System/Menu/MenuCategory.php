<?php
namespace App\Models\Common\System\Menu;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-16
 *
 * 菜单分类模型类
 */
class MenuCategory extends Base
{
  // 表名
  public $table = "system_menu_category";

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  public $appends = [];

  // 批量添加
  public $fillable = [
    'id',
    'organization_id',
    'title',
    'icon',
  ];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 菜单分类与菜单关联函数
   * ------------------------------------------
   *
   * 菜单分类与菜单关联函数
   *
   * @return [关联对象]
   */
  public function menu()
  {
    return $this->hasMany(
      'App\Models\Common\System\Menu',
      'category_id',
      'id'
    );
  }
}
