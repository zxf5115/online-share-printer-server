<?php
namespace App\Models\Platform\Module\Repair;

use App\Models\Common\Module\Repair\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 报修分类模型类
 */
class Category extends Common
{


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 报修分类与报修关联函数
   * ------------------------------------------
   *
   * 报修分类与报修关联函数
   *
   * @return [关联对象]
   */
  public function repair()
  {
    return $this->hasMany(
      'App\Models\Platform\Module\Repair',
      'category_id',
      'id'
    );
  }
}
