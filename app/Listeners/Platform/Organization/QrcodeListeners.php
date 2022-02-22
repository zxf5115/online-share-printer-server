<?php
namespace App\Listeners\Platform\Organization;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use zxf5115\Upload\File;
use App\TraitClass\ToolTrait;
use App\Models\Platform\Module\Organization;
use App\Events\Platform\Organization\QrcodeEvent;

/**
 * 生成小程序码监听器
 */
class QrcodeListeners
{
  use ToolTrait;

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
      $invite_code = $event->invite_code;
      $type = $event->type;

      // 获取微信token信息
      $result = Organization::getWeixinToken();

      if(empty($result['access_token']))
      {
        return self::error(Code::ERROR);
      }

      $token = $result['access_token'];

      $data = [
        'invite_code' => self::encrypt($invite_code),
        'type' => self::encrypt($type)
      ];

      $data = http_build_query($data);

      // 获取微信二维码数据
      $result = Organization::getQrCode($token, $data);

      // 保存小程序码
      $response = File::file_buffer($result, 'qrcode');

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
