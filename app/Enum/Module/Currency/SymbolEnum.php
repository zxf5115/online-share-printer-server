<?php
namespace App\Enum\Module\Currency;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币交易对枚举类
 */
class SymbolEnum extends BaseEnum
{
  // 货币交易推荐
  const ONLINE     = 'online';
  const OFFLINE    = 'offline';
  const SUSPEND    = 'suspend';
  const PRE_ONLINE = 'pre-online';


  // 货币交易推荐
  public static $status = [
    self::ONLINE => [
      'value' => self::ONLINE,
      'text' => '已上线'
    ],

    self::OFFLINE => [
      'value' => self::OFFLINE,
      'text' => '不可交易'
    ],

    self::SUSPEND => [
      'value' => self::SUSPEND,
      'text' => '交易暂停'
    ],

    self::PRE_ONLINE => [
      'value' => self::PRE_ONLINE,
      'text' => '即将上线'
    ]
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
   * ------------------------------------------
   * 状态值
   * ------------------------------------------
   *
   * 状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::ONLINE];
  }
}
