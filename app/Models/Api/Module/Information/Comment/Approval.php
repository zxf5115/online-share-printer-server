<?php
namespace App\Models\Api\Module\Information\Comment;

use App\Models\Common\Module\Information\Comment\Approval as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-21
 *
 * 资讯评论点赞模型类
 */
class Approval extends Common
{
  // 隐藏的属性
  protected $hidden = [
    'id',
    'organization_id',
    'comment_id',
    'member_id',
    'status',
    'create_time',
    'update_time'
  ];
}
