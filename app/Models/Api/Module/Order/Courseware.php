<?php
namespace App\Models\Api\Module\Order;

use App\Models\Common\Module\Order\Courseware as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-07
 *
 * 订单课程模型类
 */
class Courseware extends Common
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
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 订单课程与会员关联函数
   * ------------------------------------------
   *
   * 订单课程与会员关联函数
   *
   * @return [type]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Member',
      'member_id',
      'id'
    )->where(['status'=>1]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-07
   * ------------------------------------------
   * 订单课程与订单关联函数
   * ------------------------------------------
   *
   * 订单课程与订单关联函数
   *
   * @return [type]
   */
  public function order()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Order',
      'order_id',
      'id'
    )->where(['status'=>1]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 订单课程与课件关联函数
   * ------------------------------------------
   *
   * 订单课程与课件关联函数
   *
   * @return [type]
   */
  public function courseware()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Education\Courseware',
      'courseware_id',
      'id'
    )->where(['status'=>1]);
  }
}
