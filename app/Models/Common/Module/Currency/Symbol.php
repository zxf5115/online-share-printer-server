<?php
namespace App\Models\Common\Module\Currency;

use App\Models\Base;
use App\Enum\Module\Currency\SymbolEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币交易模型类
 */
class Symbol extends Base
{
  // 表名
  protected $table = "module_currency_symbol";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'symbol',
    'base_currency',
    'quote_currency',
    'state'
  ];
}
