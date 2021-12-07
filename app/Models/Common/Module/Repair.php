<?php
namespace App\Models\Common\Module;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-25
 *
 * 报修模型类
 */
class Repair extends Base
{
  // 表名
  protected $table = "module_repair";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 报修与报修分类关联函数
   * ------------------------------------------
   *
   * 报修与报修分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Repair\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 报修与会员关联表
   * ------------------------------------------
   *
   * 报修与会员关联表
   *
   * @return [关联对象]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 报修与打印机关联表
   * ------------------------------------------
   *
   * 报修与打印机关联表
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
