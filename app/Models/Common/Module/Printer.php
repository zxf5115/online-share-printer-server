<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Common\AreaEnum;
use App\Enum\Module\Printer\PrinterEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-04
 *
 * 打印机模型类
 */
class Printer extends Base
{
  // 表名
  protected $table = "module_printer";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 省信息封装
   * ------------------------------------------
   *
   * 省信息封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getProvinceIdAttribute($value)
  {
    return AreaEnum::getArea($value);
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 市信息封装
   * ------------------------------------------
   *
   * 市信息封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getCityIdAttribute($value)
  {
    return AreaEnum::getArea($value);
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 区县信息封装
   * ------------------------------------------
   *
   * 区县信息封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getRegionIdAttribute($value)
  {
    return AreaEnum::getArea($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 使用状态封装
   * ------------------------------------------
   *
   * 使用状态封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getAllotStatusAttribute($value)
  {
    return PrinterEnum::getAllotStatus($value);
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 打印机状态封装
   * ------------------------------------------
   *
   * 打印机状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getStatusAttribute($value)
  {
    return PrinterEnum::getStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 打印机与打印机日志关联函数
   * ------------------------------------------
   *
   * 打印机与打印机日志关联函数
   *
   * @return [关联对象]
   */
  public function log()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Printer\Log',
      'printer_id',
      'id',
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 打印机与所属者关联函数
   * ------------------------------------------
   *
   * 打印机与所属者关联函数
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
