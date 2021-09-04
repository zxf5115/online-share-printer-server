<?php
namespace App\Models\Api\Module\Member\Certification;

use App\Models\Common\Module\Member\Certification\Personal as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员个人认证模型类
 */
class Personal extends Common
{
  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'certification_id',
    'member_id',
    'status',
    'create_time',
    'update_time'
  ];

}
