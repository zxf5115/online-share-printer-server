<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Organization as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 机构模型类
 */
class Organization extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-22
   * ------------------------------------------
   * 获得代理商姓名
   * ------------------------------------------
   *
   * 获得代理商姓名
   *
   * @param [type] $id 代理商编号
   * @return [type]
   */
  public static function getOrganizationName($id)
  {
    if(empty($id))
    {
      return '';
    }

    $result = self::getRow(['id' => $id]);

    return $result->nickname ?: '';
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取机构数据
   * ------------------------------------------
   *
   * 获取机构数据
   *
   * @param [type] $where [description]
   * @return [type]
   */
  public static function getMemberData($where)
  {
    try
    {
      $response = 0;

      $response = self::getCount($where);

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-01-13
   * ------------------------------------------
   * 获取微信token信息
   * ------------------------------------------
   *
   * 获取微信token信息
   *
   * @return [type]
   */
  public static function  getWeixinToken()
  {
    $param = [];

    $param[] = 'grant_type=client_credential';
    $param[] = 'appid=' . config('weixin.weixin_key');
    $param[] = 'secret=' .  config('weixin.weixin_secret');

    $params = implode('&', $param);    //用&符号连起来

    $url = config('weixin.weixin_token_url') . '?' . $params;

    //请求接口
    $client = new \GuzzleHttp\Client([
        'timeout' => 60
    ]);

    $res = $client->request('GET', $url);

    return json_decode($res->getBody()->getContents(), true);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-01-13
   * ------------------------------------------
   * 获取微信小程序二维码
   * ------------------------------------------
   *
   * 获取微信小程序二维码
   *
   * @param string $token 微信token
   * @param string $invite_code 邀请码
   * @return [type]
   */
  public static function  getQrCode($token, $invite_code)
  {
    $param = [];

    $param[] = 'access_token=' . $token;

    $params = implode('&', $param);    //用&符号连起来

    $url = config('weixin.weixin_qrcode_url') . '?' . $params;

    //请求接口
    $client = new \GuzzleHttp\Client([
        'timeout' => 60
    ]);

    $res = $client->request('POST', $url, [
      'json' => [
        'path' => 'pages/home/index/index?invite_code='.$invite_code
      ]
    ]);

    return $res->getBody()->getContents();
  }
}
