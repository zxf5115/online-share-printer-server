<?php
namespace App\Models\Api\Module\Information;

use App\Models\Common\Module\Information\Label as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯标签模型类
 */
class Label extends Common
{

  // 隐藏的属性
  protected $hidden = [
    'id',
    'organization_id',
    'information_id',
    'status',
    'create_time',
    'update_time'
  ];
}
