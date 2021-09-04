<?php
namespace App\Models\Api\Module\Notice;

use App\Models\Common\Module\Notice\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 通知分类模型类
 */
class Category extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'sort',
    'status',
    'create_time',
    'update_time'
  ];

  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-11
   * ------------------------------------------
   * 通知分类与通知关联函数
   * ------------------------------------------
   *
   * 通知分类与通知关联函数
   *
   * @return [关联对象]
   */
  public function notice()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Notice',
      'category_id',
      'id'
    );
  }
}
