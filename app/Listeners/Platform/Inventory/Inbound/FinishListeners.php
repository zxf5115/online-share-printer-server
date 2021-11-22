<?php
namespace App\Listeners\Platform\Inventory\Inbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Inventory;
use App\Events\Platform\Inventory\Inbound\FinishEvent;

/**
 * 完成入库监听器
 */
class FinishListeners
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
   * @param  FinishEvent  $event
   * @return void
   */
  public function handle(FinishEvent $event)
  {
    try
    {
      $model = $event->model;
      $code  = $event->code;

      $inventory = new Inventory();

      $inventory->model      = $model;
      $inventory->code       = $code;
      $inventory->save();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
