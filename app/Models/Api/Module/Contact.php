<?php
namespace App\Models\Api\Module;

use App\Models\Common\Module\Contact as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-06
 *
 * 联系模型类
 */
class Contact extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'member_id',
    'status',
    'create_time',
    'update_time'
  ];
}
