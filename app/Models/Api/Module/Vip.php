<?php
namespace App\Models\Api\Module;

use App\Models\Common\Module\Vip as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 贵宾模型类
 */
class Vip extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'pivot',
    'status',
    'create_time',
    'update_time'
  ];
}
