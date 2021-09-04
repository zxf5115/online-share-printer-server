<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Money as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员红包模型类
 */
class Money extends Common
{
  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'member_id',
    'confirm_status',
    'status',
    'update_time'
  ];
}
