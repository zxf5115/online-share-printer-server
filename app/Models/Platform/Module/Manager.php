<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Organization as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-25
 *
 * 会员模型类
 */
class Manager extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'printer_total',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 打印机数量封装
   * ------------------------------------------
   *
   * 打印机数量封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getPrinterTotalAttribute($value)
  {
    return $this->memberPrinter()->count();
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取打印机数量
   * ------------------------------------------
   *
   * 获取打印机数量
   *
   * @return [type]
   */
  public static function getCountData()
  {
    $where = [
      'status'  => 1,
      'role_id' => 2
    ];

    return self::getCount($where);
  }


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 店长与打印机关联函数
   * ------------------------------------------
   *
   * 店长与打印机关联函数
   *
   * @return [关联对象]
   */
  public function memberPrinter()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Member\Printer',
      'member_id',
      'id',
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 代理商与打印机关联函数
   * ------------------------------------------
   *
   * 代理商与打印机关联函数
   *
   * @return [关联对象]
   */
  public function printer()
  {
    return $this->belongsToMany(
      'App\Models\Common\Module\Printer',
      'module_member_printer',
      'member_id',
      'printer_id',
    );
  }
}
