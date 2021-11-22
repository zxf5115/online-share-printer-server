<?php
namespace App\Listeners\Platform\Organization\Asset\Printer;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Organization\Asset;
use App\Events\Platform\Organization\Asset\Printer\TotalEvent;

/**
 * 代理商设备数量监听器
 */
class TotalListeners
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
   * @param  TotalEvent  $event
   * @return void
   */
  public function handle(TotalEvent $event)
  {
    try
    {
      $member_id = $event->member_id;
      $total     = $event->total;

      $model = Asset::firstOrNew(['member_id' => $member_id]);

      $model->increment('already_printer_total', $total);
      $model->save();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
