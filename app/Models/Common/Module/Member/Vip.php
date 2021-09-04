<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员贵宾模型类
 */
class Vip extends Base
{
  // 表名
  public $table = "module_member_vip";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
    'vip_id'
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


  /**
   * 转换属性类型
   */
  protected $casts = [
    'status'      => 'array',
    'end_time'    => 'datetime:Y-m-d H:i:s',
    'create_time' => 'datetime:Y-m-d H:i:s',
    'update_time' => 'datetime:Y-m-d H:i:s',
  ];


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 会员贵宾与贵宾关联函数
   * ------------------------------------------
   *
   * 会员贵宾与贵宾关联函数
   *
   * @return [关联对象]
   */
  public function gvip()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Vip',
      'vip_id',
      'id'
    );
  }
}
