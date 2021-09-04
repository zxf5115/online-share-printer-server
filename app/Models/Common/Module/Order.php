<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Order\OrderEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-29
 *
 * 订单模型类
 */
class Order extends Base
{
  // 表名
  protected $table = "module_order";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];

  /**
   * 转换属性类型
   */
  protected $casts = [
    'status' => 'array',
    'pay_time' => 'datetime:Y-m-d H:i:s',
    'create_time' => 'datetime:Y-m-d H:i:s',
    'update_time' => 'datetime:Y-m-d H:i:s',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 支付类型封装
   * ------------------------------------------
   *
   * 支付类型封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getPayTypeAttribute($value)
  {
    return OrderEnum::getTypeStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 订单状态封装
   * ------------------------------------------
   *
   * 订单状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getPayStatusAttribute($value)
  {
    return OrderEnum::getPayStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 支付状态封装
   * ------------------------------------------
   *
   * 支付状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getOrderStatusAttribute($value)
  {
    return OrderEnum::getOrderStatus($value);
  }


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
      'courseware_id',
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
   * @dateTime 2021-07-08
   * ------------------------------------------
   * 课程订单与课程订单日志关联函数
   * ------------------------------------------
   *
   * 课程订单与课程订单日志关联函数
   *
   * @return [关联对象]
   */
  public function log()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Order\Log',
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
      'App\Models\Common\Module\Member',
      'member_id',
      'id'
    );
  }
}
