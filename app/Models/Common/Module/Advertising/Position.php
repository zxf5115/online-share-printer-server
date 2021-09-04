<?php
namespace App\Models\Common\Module\Advertising;

use App\Models\Base;
use App\Enum\Module\Advertising\PositionEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-05
 *
 * 广告位模型类
 */
class Position extends Base
{
  // 表名
  protected $table = "module_advertising_position";

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
   * @dateTime 2021-06-07
   * ------------------------------------------
   * 广告位置与广告关联函数
   * ------------------------------------------
   *
   * 广告位置与广告关联函数
   *
   * @return [关联对象]
   */
  public function advertising()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Advertising',
      'position_id',
      'id'
    );
  }
}
