<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Enum\Module\Member\OrderEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-30
 *
 * 会员订单模型类
 */
class Order extends Base
{
  // 表名
  public $table = "module_member_order";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
    'course_id',
    'production_id',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

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
   * @dateTime 2020-12-30
   * ------------------------------------------
   * 订单支付类型封装
   * ------------------------------------------
   *
   * 订单支付类型封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getPayTypeAttribute($value)
  {
    return OrderEnum::getTypeStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-30
   * ------------------------------------------
   * 订单支付状态封装
   * ------------------------------------------
   *
   * 订单支付状态封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getPayStatusAttribute($value)
  {
    return OrderEnum::getPayStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-30
   * ------------------------------------------
   * 订单状态封装
   * ------------------------------------------
   *
   * 订单状态封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getOrderStatusAttribute($value)
  {
    return OrderEnum::getOrderStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-26
   * ------------------------------------------
   * 会员订单与学员关联表
   * ------------------------------------------
   *
   * 会员订单与学员关联表
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

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-26
   * ------------------------------------------
   * 会员订单与课程关联表
   * ------------------------------------------
   *
   * 会员订单与课程关联表
   *
   * @return [关联对象]
   */
  public function course()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Education\Course',
      'course_id',
      'id'
    );
  }
}
