<?php
namespace App\Models\Platform\Module\Currency;

use App\Models\Common\Module\Currency\Symbol as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币交易模型类
 */
class Symbol extends Common
{
  // 附加数据
  protected $appends = [
    'title'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-02
   * ------------------------------------------
   * 交易对名称状态封装
   * ------------------------------------------
   *
   * 交易对名称状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getTitleAttribute($value)
  {
    $base_currency  = strtoupper($this->base_currency);

    $quote_currency = strtoupper($this->quote_currency);

    return $base_currency . ' - ' . $quote_currency;
  }
}
