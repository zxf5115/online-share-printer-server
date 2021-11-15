<?php
namespace App\Models\Common\Module\Logistics;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-13
 *
 * 物流公司模型类
 */
class Company extends Base
{
  // 表名
  protected $table = "module_logistics_company";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];

}
