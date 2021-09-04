<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-26
 *
 * 会员设置模型类
 */
class Cart extends Base
{
  // 表名
  public $table = "module_member_cart";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'member_id',
    'courseware_id',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-26
   * ------------------------------------------
   * 会员档案与会员关联表
   * ------------------------------------------
   *
   * 会员档案与会员关联表
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
   * @dateTime 2021-06-26
   * ------------------------------------------
   * 会员购物车与课程关联表
   * ------------------------------------------
   *
   * 会员购物车与课程关联表
   *
   * @return [关联对象]
   */
  public function courseware()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Education\Courseware',
      'courseware_id',
      'id'
    );
  }
}
