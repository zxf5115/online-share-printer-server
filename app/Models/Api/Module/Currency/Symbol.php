<?php
namespace App\Models\Api\Module\Currency;

use App\Models\Common\Module\Currency\Symbol as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币交易模型类
 */
class Symbol extends Common
{
  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'sort',
    'status',
    'create_time',
    'update_time'
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-12
   * ------------------------------------------
   * 获取第三方数据
   * ------------------------------------------
   *
   * 获取第三方数据
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public static function getData($symbol)
  {
    $api_key = getenv('CURRENCY_API_KEY');

    $url = getenv('CURRENCY_SYMBOL_URL');

    $params = [
      'api_key'     => $api_key,
      'market_pair' => $symbol
    ];

    $param = http_build_query($params);

    $url = $url . '?' . $param;

    $response = json_decode(curl($url));

    return $response;
  }
}
