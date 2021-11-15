<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Inventory\OutboundEnum;
use App\Enum\Module\Inventory\InventoryEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-13
 *
 * 出库单模型类
 */
class Outbound extends Base
{
  // 表名
  protected $table = "module_outbound";

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
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 库存类型封装
   * ------------------------------------------
   *
   * 库存类型封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getTypeAttribute($value)
  {
    return InventoryEnum::getTypeStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 出库类型封装
   * ------------------------------------------
   *
   * 出库类型封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getCategoryAttribute($value)
  {
    return OutboundEnum::getTypeStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 出库与出库详情关联函数
   * ------------------------------------------
   *
   * 出库与出库详情关联函数
   *
   * @return [关联对象]
   */
  public function detail()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Outbound\Detail',
      'outbound_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 出库与出库资源关联函数
   * ------------------------------------------
   *
   * 出库与出库资源关联函数
   *
   * @return [关联对象]
   */
  public function resource()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Outbound\Resource',
      'outbound_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-12
   * ------------------------------------------
   * 出库与出库物流关联函数
   * ------------------------------------------
   *
   * 出库与出库物流关联函数
   *
   * @return [关联对象]
   */
  public function logistics()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Outbound\Logistics',
      'outbound_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 出库与代理商关联表
   * ------------------------------------------
   *
   * 出库与代理商关联表
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
}
