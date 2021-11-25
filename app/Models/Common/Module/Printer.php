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
   * 转换属性类型
   */
  protected $casts = [
    'status' => 'array',
    'bind_time' => 'datetime:Y-m-d H:i:s',
    'activate_time' => 'datetime:Y-m-d H:i:s',
    'create_time' => 'datetime:Y-m-d H:i:s',
    'update_time' => 'datetime:Y-m-d H:i:s',
  ];


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
  public function getBindStatusAttribute($value)
  {
    return PrinterEnum::getBindStatus($value);
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
  public function getActivateStatusAttribute($value)
  {
    return PrinterEnum::getActivateStatus($value);
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
   * 打印机与一级代理商关联函数
   * ------------------------------------------
   *
   * 打印机与一级代理商关联函数
   *
   * @return [关联对象]
   */
  public function first()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'first_level_agent_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 打印机与二级代理商关联函数
   * ------------------------------------------
   *
   * 打印机与二级代理商关联函数
   *
   * @return [关联对象]
   */
  public function second()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'second_level_agent_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
   * ------------------------------------------
   * 打印机与店长关联函数
   * ------------------------------------------
   *
   * 打印机与店长关联函数
   *
   * @return [关联对象]
   */
  public function manager()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'manager_id',
      'id'
    );
  }
}
