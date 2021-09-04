<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Archive as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 会员档案模型类
 */
class Archive extends Common
{
  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'member_id',
    'status',
    'create_time',
    'update_time'
  ];
}
