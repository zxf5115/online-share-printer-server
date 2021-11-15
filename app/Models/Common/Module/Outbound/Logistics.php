<?php
namespace App\Models\Common\Module\Outbound;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 出库物流模型类
 */
class Logistics extends Base
{
  // 表名
  protected $table = "module_outbound_logistics";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'outbound_id'
  ];


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-16
   * ------------------------------------------
   * 出库物流与出库关联表
   * ------------------------------------------
   *
   * 出库物流与出库关联表
   *
   * @return [关联对象]
   */
  public function outbound()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Outbound',
      'outbound_id',
      'id'
    );
  }
}
