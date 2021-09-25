<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Enum\Module\Member\PrinterEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-25
 *
 * 会员打印机模型类
 */
class Printer extends Base
{
  // 表名
  public $table = "module_member_printer";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'member_id',
    'printer_id'
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


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
  public function getUseStatusAttribute($value)
  {
    return PrinterEnum::getUseStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 会员打印机与会员关联表
   * ------------------------------------------
   *
   * 会员打印机与会员关联表
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
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 会员打印机与打印机关联表
   * ------------------------------------------
   *
   * 会员打印机与打印机关联表
   *
   * @return [关联对象]
   */
  public function printer()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Printer',
      'printer_id',
      'id'
    );
  }
}
