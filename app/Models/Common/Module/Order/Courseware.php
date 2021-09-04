<?php
namespace App\Models\Common\Module\Order;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 订单课程关联模型类
 */
class Courseware extends Base
{
  // 表名
  public $table = 'module_order_courseware';

  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'create_time',
    'update_time'
  ];

  /**
   * 可以被批量赋值的属性
   */
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
    'order_id',
    'courseware_id',
  ];

  // 追加到模型数组表单的访问器
  public $appends = [];



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
      'App\Models\Common\Module\Member',
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
      'App\Models\Common\Module\Order',
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
      'App\Models\Common\Module\Education\Courseware',
      'courseware_id',
      'id'
    )->where(['status'=>1]);
  }
}
