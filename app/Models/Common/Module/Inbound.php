<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Inventory\InboundEnum;
use App\Enum\Module\Inventory\InventoryEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-17
 *
 * 入库单模型类
 */
class Inbound extends Base
{
  // 表名
  protected $table = "module_inbound";

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
   * 入库类型封装
   * ------------------------------------------
   *
   * 入库类型封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getCategoryAttribute($value)
  {
    return InboundEnum::getTypeStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-17
   * ------------------------------------------
   * 入库与入库详情关联函数
   * ------------------------------------------
   *
   * 入库与入库详情关联函数
   *
   * @return [关联对象]
   */
  public function detail()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Inbound\Detail',
      'inbound_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-17
   * ------------------------------------------
   * 入库与入库资源关联函数
   * ------------------------------------------
   *
   * 入库与入库资源关联函数
   *
   * @return [关联对象]
   */
  public function resource()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Inbound\Resource',
      'inbound_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-17
   * ------------------------------------------
   * 入库与入库物流关联函数
   * ------------------------------------------
   *
   * 入库与入库物流关联函数
   *
   * @return [关联对象]
   */
  public function logistics()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Inbound\Logistics',
      'inbound_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-17
   * ------------------------------------------
   * 入库与代理商关联表
   * ------------------------------------------
   *
   * 入库与代理商关联表
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
