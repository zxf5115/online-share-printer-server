<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Organization as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 代理商模型类
 */
class Agent extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'printer_total',
    'below_agent_total',
    'below_manager_total',
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
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 下属代理商封装
   * ------------------------------------------
   *
   * 下属代理商封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getBelowAgentTotalAttribute($value)
  {
    $where = [
      'status'    => 1,
      'role_id'   => 3,
      'parent_id' => $this->id
    ];

    return self::where($where)->count();
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 下属店长封装
   * ------------------------------------------
   *
   * 下属店长封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getBelowManagerTotalAttribute($value)
  {
    $where = [
      'status'    => 1,
      'role_id'   => 2,
      'parent_id' => $this->id
    ];

    return self::where($where)->count();
  }


  // 关联函数 ------------------------------------------------------


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
    )->withPivot('use_status');
  }
}
