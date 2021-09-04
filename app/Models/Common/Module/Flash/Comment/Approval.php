<?php
namespace App\Models\Common\Module\Flash\Comment;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 快讯评论点赞模型类
 */
class Approval extends Base
{
  // 表名
  protected $table = "module_flash_comment_approval";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'organization_id',
    'comment_id',
    'member_id',
  ];
}
