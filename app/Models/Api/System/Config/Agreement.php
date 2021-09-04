<?php
namespace App\Models\Api\System\Config;

use App\Models\Common\System\Config\Agreement as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-08
 *
 * 配置协议模型类
 */
class Agreement extends Common
{
  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'name',
    'title',
    'status',
    'create_time',
    'update_time'
  ];
}
