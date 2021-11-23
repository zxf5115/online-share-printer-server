<?php
namespace App\Models\Common\Module\Inbound;

use App\Models\Base;
use App\Enum\Module\Inventory\Inbound\AbnormalEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-13
 *
 * 入库异常模型类
 */
class Abnormal extends Base
{
  // 表名
  protected $table = "module_inbound_abnormal";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'inbound_id',
    'member_id',
    'type',
    'code'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-23
   * ------------------------------------------
   * 入库异常类型封装
   * ------------------------------------------
   *
   * 入库异常类型封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getTypeAttribute($value)
  {
    return AbnormalEnum::getTypeStatus($value);
  }

  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-17
   * ------------------------------------------
   * 入库异常与入库关联表
   * ------------------------------------------
   *
   * 入库异常与入库关联表
   *
   * @return [关联对象]
   */
  public function inbound()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Inbound',
      'inbound_id',
      'id'
    );
  }
}
