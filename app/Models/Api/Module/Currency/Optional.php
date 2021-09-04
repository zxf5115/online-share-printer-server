<?php
namespace App\Models\Api\Module\Currency;

use App\Models\Common\Module\Currency\Optional as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-13
 *
 * 自选货币模型类
 */
class Optional extends Common
{
  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'sort',
    'status',
    'create_time',
    'update_time'
  ];


}
