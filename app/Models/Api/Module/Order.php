<?php
namespace App\Models\Api\Module;

use App\Models\Common\Module\Order as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-29
 *
 * 课程订单模型类
 */
class Order extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'courseware_id',
    'member_id',
    'status',
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------




  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-07
   * ------------------------------------------
   * 课程订单与课件关联函数
   * ------------------------------------------
   *
   * 课程订单与课件关联函数
   *
   * @return [关联对象]
   */
  public function courseware()
  {
    return $this->belongsToMany(
      'App\Models\Common\Module\Education\Courseware',
      'module_order_courseware',
      'order_id',
      'courseware_id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-07
   * ------------------------------------------
   * 课程订单与课件关联函数
   * ------------------------------------------
   *
   * 课程订单与课件关联函数
   *
   * @return [关联对象]
   */
  public function coursewareRelevance()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Order\Courseware',
      'order_id',
      'id',
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 课程订单与学员关联函数
   * ------------------------------------------
   *
   * 课程订单与学员关联函数
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
