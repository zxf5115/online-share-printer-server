<?php
namespace App\Models\Api\Module\Advertising;

use App\Models\Common\Module\Advertising\Position as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-06
 *
 * 广告位模型类
 */
class Position extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'create_time',
    'update_time'
  ];

  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-07
   * ------------------------------------------
   * 广告位置与广告关联函数
   * ------------------------------------------
   *
   * 广告位置与广告关联函数
   *
   * @return [关联对象]
   */
  public function advertising()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Advertising',
      'position_id',
      'id'
    );
  }
}
