<?php
namespace App\Models\Api\Module\Flash;

use App\Models\Common\Module\Flash\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 快讯分类模型类
 */
class Category extends Common
{

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'status',
    'sort',
    'create_time',
    'update_time'
  ];

  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 快讯分类置与快讯关联函数
   * ------------------------------------------
   *
   * 快讯分类置与快讯关联函数
   *
   * @return [关联对象]
   */
  public function flash()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Flash',
      'flash_id',
      'id'
    );
  }
}
