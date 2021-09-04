<?php
namespace App\Models\Api\Module\Flash;

use App\Models\Common\Module\Flash\Benefit as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 快讯利益模型类
 */
class Benefit extends Common
{
  // 隐藏的属性
  protected $hidden = [
    'id',
    'organization_id',
    'flash_id',
    'member_id',
    'status',
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 快讯利益置与快讯关联函数
   * ------------------------------------------
   *
   * 快讯利益置与快讯关联函数
   *
   * @return [关联对象]
   */
  public function flash()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Flash',
      'flash_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-11
   * ------------------------------------------
   * 评论与评论人关联表
   * ------------------------------------------
   *
   * 评论与评论人关联表
   *
   * @return [关联对象]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Member',
      'member_id',
      'id'
    );
  }
}
