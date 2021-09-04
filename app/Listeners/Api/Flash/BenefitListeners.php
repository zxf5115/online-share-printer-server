<?php
namespace App\Listeners\Api\Flash;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Api\Module\Flash;
use App\Events\Api\Flash\BenefitEvent;

/**
 * 快讯利益监听器
 */
class BenefitListeners
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  BenefitEvent  $event
   * @return void
   */
  public function handle(BenefitEvent $event)
  {
    try
    {
      $type     = $event->type;
      $flash_id = $event->flash_id;

      $flash = Flash::getRow(['id' => $flash_id]);

      // 利多
      if(1 == $type)
      {
        $flash->increment('bullish_total', 1);
      }
      else
      {
        $flash->increment('bearish_total', 1);
      }

      $flash->save();

      return true;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
