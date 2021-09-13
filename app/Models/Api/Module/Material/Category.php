<?php
namespace App\Models\Api\Module\Material;

use App\Models\Common\Module\Material\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 耗材分类模型类
 */
class Category extends Common
{


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 耗材分类与耗材关联函数
   * ------------------------------------------
   *
   * 耗材分类与耗材关联函数
   *
   * @return [关联对象]
   */
  public function material()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Material',
      'category_id',
      'id'
    );
  }
}
