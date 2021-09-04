<?php
namespace App\Models\Api\Module;

use App\Models\Common\Module\Problem as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-05-28
 *
 * 常见问题模型类
 */
class Problem extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'category_id',
    'status',
    'create_time',
    'update_time'
  ];

  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 常见问题与常见问题分类关联函数
   * ------------------------------------------
   *
   * 常见问题与常见问题分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Problem\Category',
      'category_id',
      'id'
    );
  }
}
