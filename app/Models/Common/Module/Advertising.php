<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Advertising\AdvertisingEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-05
 *
 * 广告模型类
 */
class Advertising extends Base
{
  // 表名
  protected $table = "module_advertising";

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
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 广告链接类型封装
   * ------------------------------------------
   *
   * 广告链接类型封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getTypeAttribute($value)
  {
    return AdvertisingEnum::getTypeStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 广告与广告位关联函数
   * ------------------------------------------
   *
   * 广告与广告位关联函数
   *
   * @return [关联对象]
   */
  public function position()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Advertising\Position',
      'position_id',
      'id'
    )->where(['status'=>1]);
  }
}
