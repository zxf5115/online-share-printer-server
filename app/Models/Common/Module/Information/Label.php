<?php
namespace App\Models\Common\Module\Information;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-09
 *
 * 资讯标签模型类
 */
class Label extends Base
{
  // 表名
  protected $table = "module_information_label";

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
    'information_id',
    'label_id',
  ];

}
