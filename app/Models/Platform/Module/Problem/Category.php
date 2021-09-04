<?php
namespace App\Models\Platform\Module\Problem;

use App\Models\Common\Module\Problem\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-06
 *
 * 常见问题分类模型类
 */
class Category extends Common
{

  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-05-29
   * ------------------------------------------
   * 常见问题分类置与常见问题关联函数
   * ------------------------------------------
   *
   * 常见问题分类置与常见问题关联函数
   *
   * @return [关联对象]
   */
  public function problem()
  {
    return $this->hasMany(
      'App\Models\Platform\Module\Problem',
      'category_id',
      'id'
    );
  }
}
