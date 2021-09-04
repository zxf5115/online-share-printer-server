<?php
namespace App\Models\Api\System;

use App\Models\Common\System\Route as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-22
 *
 * 接口路由模型类
 */
class Route extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'create_time',
    'update_time'
  ];
}
