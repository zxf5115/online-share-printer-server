<?php
namespace App\Models\Api\System;

use App\Models\Common\System\Config as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-25
 *
 * 配置模型类
 */
class Config extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'category_id',
    'type',
    'content',
    'status',
    'create_time',
    'update_time'
  ];
}
