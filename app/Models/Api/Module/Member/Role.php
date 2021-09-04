<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Role as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-09
 *
 * 会员角色模型类
 */
class Role extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'create_time',
    'update_time'
  ];


}
