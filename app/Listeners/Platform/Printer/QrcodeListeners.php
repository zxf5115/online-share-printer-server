<?php
namespace App\Listeners\Platform\Printer;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Common\System\Config;
use App\Models\Platform\Module\Printer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Events\Platform\Printer\QrcodeEvent;

/**
 * 生成设备二维码监听器
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
      $printer_id = $event->printer_id;

      $params = $event->params;

      $filename = md5(time() . rand(1, 9999999)). '.png';

      $uri = storage_path('app/public/qrcode/' . $filename);

      $web_url = Config::getConfigValue('web_url');

      $url = $web_url . '/storage/qrcode/' . $filename;

      // 生成带有设备信息的二维码
      QrCode::format('png')->size(300)->encoding('UTF-8')->generate($params, $uri);


      $model = Printer::getRow(['id' => $printer_id]);

      $model->qrcode_url = $url;
      $model->save();

      return true;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
