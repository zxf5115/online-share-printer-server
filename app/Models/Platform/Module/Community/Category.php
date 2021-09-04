<?php
namespace App\Models\Platform\Module\Community;

use App\Models\Common\Module\Community\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-21
 *
 * 社区分类模型类
 */
class Category extends Common
{

  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
   * ------------------------------------------
   * 社区分类与社区关联函数
   * ------------------------------------------
   *
   * 社区分类与社区关联函数
   *
   * @return [关联对象]
   */
  public function community()
  {
    return $this->hasMany(
      'App\Models\Platform\Module\Community',
      'community_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-02
   * ------------------------------------------
   * 社区分类与货币交易对关联函数
   * ------------------------------------------
   *
   * 社区分类与货币交易对关联函数
   *
   * @return [关联对象]
   */
  public function symbol()
  {
    return $this->belongsTo(
      'App\Models\Platform\Module\Currency\symbol',
      'symbol_id',
      'id'
    );
  }
}
