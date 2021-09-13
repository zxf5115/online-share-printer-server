<?php
namespace App\Models\Common\Module\Printer;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-05
 *
 * 订单日志模型类
 */
class Log extends Base
{
  // 表名
  public $table = 'module_printer_log';

  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];

  /**
   * 可以被批量赋值的属性
   */
  public $fillable = [];

  // 追加到模型数组表单的访问器
  public $appends = [];



  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 订单日志与会员关联函数
   * ------------------------------------------
   *
   * 订单日志与会员关联函数
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
   * 订单日志与订单关联函数
   * ------------------------------------------
   *
   * 订单日志与订单关联函数
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
}
