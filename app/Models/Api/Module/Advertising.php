<?php
namespace App\Models\Api\Module;

use App\Models\Common\Module\Advertising as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-26
 *
 * 广告模型类
 */
class Advertising extends Common
{
  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'position_id',
    'sort',
    'status',
    'create_time',
    'update_time'
  ];
}
