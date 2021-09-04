<?php
namespace App\Models\Common\System\Config;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-13
 *
 * 系统协议模型类
 */
class Agreement extends Base
{
  // 表名
  public $table = "system_config_agreement";

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  public $appends = [];

  // 批量添加
  public $fillable = ['id'];
}
