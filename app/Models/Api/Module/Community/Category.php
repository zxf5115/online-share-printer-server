<?php
namespace App\Models\Api\Module\Community;

use App\Models\Common\Module\Community\Category as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 社区分类模型类
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
   * 社区分类置与社区关联函数
   * ------------------------------------------
   *
   * 社区分类置与社区关联函数
   *
   * @return [关联对象]
   */
  public function community()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Community',
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
      'App\Models\Api\Module\Currency\symbol',
      'symbol_id',
      'id'
    );
  }
}
