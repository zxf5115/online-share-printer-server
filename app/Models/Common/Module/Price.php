<?php
namespace App\Models\Common\Module;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-17
 *
 * 价格模型类
 */
class Price extends Base
{
  // 表名
  public $table = "module_price";

  // 可以批量修改的字段
  public $fillable = ['id'];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

}
