<?php
namespace App\Listeners\Platform\Inventory\Outbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Outbound;
use App\Events\Platform\Inventory\Outbound\AutoEvent;

class AutoListeners
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
   * @param  AutoEvent  $event
   * @return void
   */
  public function handle(AutoEvent $event)
  {
    try
    {
      $member_id = $event->member_id;
      $total     = $event->total;

      $model = new Outbound();

      $model->type      = 1;
      $model->category  = 1;
      $model->member_id = $member_id;
      $model->total     = $total;
      $model->save();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
