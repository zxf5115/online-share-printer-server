<?php
namespace App\Models\Common\Module\Member\Certification;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员个人认证模型类
 */
class Personal extends Base
{
  use \Awobaz\Compoships\Compoships;

  // 表名
  public $table = "module_member_certification_personal";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'member_id',
    'id_card_front_picture',
    'id_card_behind_picture',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

}
