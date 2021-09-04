<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Production\Comment as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-12
 *
 * 会员评论模型类
 */
class Comment extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];
}
