<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Cart as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 会员购物车模型类
 */
class Cart extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'member_id',
    'status',
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-26
   * ------------------------------------------
   * 会员购物车与会员关联表
   * ------------------------------------------
   *
   * 会员购物车与会员关联表
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


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-26
   * ------------------------------------------
   * 会员购物车与课程关联表
   * ------------------------------------------
   *
   * 会员购物车与课程关联表
   *
   * @return [关联对象]
   */
  public function courseware()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Education\Courseware',
      'courseware_id',
      'id'
    );
  }
}
