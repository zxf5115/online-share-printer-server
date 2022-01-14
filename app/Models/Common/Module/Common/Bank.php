<?php
namespace App\Models\Common\Module\Common;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-01-14
 *
 * 主流银行模型类
 */
class Bank extends Base
{
  // 表名
  protected $table = "module_bank";

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'sort',
    'status',
    'create_time',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];

}
