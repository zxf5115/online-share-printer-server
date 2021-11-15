<?php
namespace App\Models\Common\Module\Inventory;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 库存日志模型类
 */
class Log extends Base
{
  // 表名
  protected $table = "module_inventory_log";

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
   * 库存日志与库存关联表
   * ------------------------------------------
   *
   * 库存日志与库存关联表
   *
   * @return [关联对象]
   */
  public function inventory()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Inventory',
      'inventory_id',
      'id'
    );
  }
}
