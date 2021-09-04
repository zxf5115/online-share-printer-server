<?php
namespace App\Models\Api\Module\Information;

use App\Models\Common\Module\Information\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯分类模型类
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
   * 资讯分类置与资讯关联函数
   * ------------------------------------------
   *
   * 资讯分类置与资讯关联函数
   *
   * @return [关联对象]
   */
  public function information()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Information',
      'information_id',
      'id'
    );
  }
}
