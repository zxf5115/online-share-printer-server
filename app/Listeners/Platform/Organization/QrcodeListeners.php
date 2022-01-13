<?php
namespace App\Listeners\Platform\Organization;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Organization;
use App\Events\Platform\Organization\QrcodeEvent;

/**
 * 生成小程序码监听器
 */
class QrcodeListeners
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {

  }

  /**
   * Handle the event.
   *
   * @param  QrcodeEvent  $event
   * @return void
   */
  public function handle(QrcodeEvent $event)
  {
    try
    {
      $member_id = $event->member_id;
      $total     = $event->total;

      // 获取微信token信息
      $result = Organization::getWeixinToken();

      if(empty($result['access_token']))
      {
        return self::error(Code::ERROR);
      }

      $token = $result['access_token'];

      // 获取微信二维码数据
      $result = Organization::getQrCode($token, $member_id);

dd($result);

      $filename = md5(time() . rand(1, 9999999)). '.png';

      $uri = storage_path('app/public/qrcode/' . $filename);

      $web_url = Config::getConfigValue('web_url');

      $url = $web_url . '/storage/qrcode/' . $filename;

      file_put_contents($uri, $result);

      $response['qrcode'] = $url;


    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
