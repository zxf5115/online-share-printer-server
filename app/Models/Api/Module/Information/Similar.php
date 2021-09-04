<?php
namespace App\Models\Api\Module\Information;

use App\Models\Common\Module\Information\Similar as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-12
 *
 * 资讯关联模型类
 */
class Similar extends Common
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
