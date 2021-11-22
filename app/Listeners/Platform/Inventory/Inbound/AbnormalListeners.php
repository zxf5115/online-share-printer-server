<?php
namespace App\Listeners\Platform\Inventory\Inbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Inbound\Abnormal;
use App\Events\Platform\Inventory\Inbound\AbnormalEvent;

/**
 * 入库异常监听器
 */
class AbnormalListeners
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
   * @param  AbnormalEvent  $event
   * @return void
   */
  public function handle(AbnormalEvent $event)
  {
    try
    {
      $inbound_id = $event->inbound_id;
      $member_id  = $event->member_id;
      $type       = $event->type;
      $model      = $event->model;
      $code       = $event->code;

      $abnormal = new Abnormal();

      $abnormal->inbound_id = $inbound_id;
      $abnormal->member_id  = $member_id;
      $abnormal->type       = $type;
      $abnormal->model      = $model;
      $abnormal->code       = $code;
      $abnormal->save();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
