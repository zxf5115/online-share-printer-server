<?php
namespace App\Modules\Jpush;

use Log;
use JPush\Client;
use App\Exceptions\BaseResponseException;

class JpushService
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-02
   * ------------------------------------------
   * 初始化极光推送
   * ------------------------------------------
   *
   * 初始化极光推送
   *
   * @param [type] $app
   * @return [type]
   */
  public static function initialize($app)
  {
    $appKey = config('jpush.app_key');
    $master = config('jpush.master_secret');

    $client = new Client($appKey, $master);

    return $client;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-02
   * ------------------------------------------
   * android 或 ios 通过 别名 给单个设备或多个设备推送消息
   * ------------------------------------------
   *
   * android 或 ios 通过 别名 给单个设备或多个设备推送消息
   *
   * @param [type] $params 推送参数
   * @return [type]
   */
  public static function androidOrIosPushByAlias($params)
  {
    // 推送平台
    $platform = data_get($params, 'platform');

    // 推送标题
    $title = data_get($params, 'title');

    // 推送内容
    $content = data_get($params, 'content');

    // 通知栏样式 ID
    $builderId = data_get($params, 'builderId');

    // 附加字段 (可用于给前端返回，进行其他业务操作，例如：返回orderId，用于点击通知后跳转到订单详情页面)
    $extras = data_get($params, 'extras');

    // 推送目标 (别名)
    $alias = data_get($params, 'alias');

    // 推送目标 (注册ID)
    $registrationId = data_get($params, 'registrationId');

    // 推送类型 (1-别名 2-注册id 3-全部(ios 或 android))
    $type = data_get($params, 'type');

    // 返回一个推送 Payload 构建器
    $push = self::initialize($platform)->push();

    $push->setPlatform($platform);

    switch ($type)
    {
      // 通过别名推送
      case 1:
        $push->addAlias($alias);
        break;
      // 通过注册 ID 推送
      case 2:
        $push->addRegistrationId($registrationId);
        break;
      // 推送全部(android 或 ios)
      case 3:
        $push->addAllAudience();
        break;
    }

    $push->androidNotification($content, [ // android 通知
      "title" => $title,
      "builder_id" => $builderId,
      "extras" => $extras,
    ])->iosNotification($content, [ // ios 通知
      "sound" => "sound", // 通知提示声音，如果无此字段，则此消息无声音提示；
      "badge" => "+1", // 应用角标（APP右上角的数字）0 清除 默认 +1
      "extras" => $extras
    ])->options([ // 推送参数
      'apns_production' => config('jpush.environment') // APNs 是否生产环境 (ios)
    ]);

    $response = $push->send();

    if($response['http_code'] != 200)
    {
      Log::info('推送失败 by alias',
        compact('response', 'type', 'platform', 'alias', 'registrationId', 'title', 'content')
      );
    }

    return $response;
  }
}
