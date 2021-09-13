<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Material as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 耗材模型类
 */
class Material extends Common
{


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 耗材与耗材分类关联函数
   * ------------------------------------------
   *
   * 耗材与耗材分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Platform\Module\Material\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 打印机与所属者关联函数
   * ------------------------------------------
   *
   * 打印机与所属者关联函数
   *
   * @return [关联对象]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Platform\Module\Member',
      'member_id',
      'id'
    );
  }
}
