<?php
namespace App\Models\Api\Module\Complain;

use App\Models\Common\Module\Complain\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-06
 *
 * 投诉分类模型类
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
   * @dateTime 2020-12-28
   * ------------------------------------------
   * 投诉分类置与广告关联函数
   * ------------------------------------------
   *
   * 投诉分类置与广告关联函数
   *
   * @return [关联对象]
   */
  public function complain()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Complain',
      'category_id',
      'id'
    );
  }
}
