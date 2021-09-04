<?php
namespace App\Models\Common\Module\Flash;

use App\Models\Base;
use App\Enum\Module\Flash\BenefitEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 快讯利益模型类
 */
class Benefit extends Base
{
  // 表名
  protected $table = "module_flash_benefit";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'member_id',
    'flash_id',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-20
   * ------------------------------------------
   * 学员冻结状态封装
   * ------------------------------------------
   *
   * 学员冻结状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getFeelStatusAttribute($value)
  {
    return BenefitEnum::getStatus($value);
  }



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 快讯利益置与快讯关联函数
   * ------------------------------------------
   *
   * 快讯利益置与快讯关联函数
   *
   * @return [关联对象]
   */
  public function flash()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Flash',
      'flash_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
   * ------------------------------------------
   * 社区点赞与学员关联函数
   * ------------------------------------------
   *
   * 社区点赞与学员关联函数
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
}
