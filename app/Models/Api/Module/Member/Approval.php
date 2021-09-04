<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Production\Approval as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 会员点赞模型类
 */
class Approval extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];
}
