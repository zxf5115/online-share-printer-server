<?php
namespace App\Listeners\Platform\Inventory\Inbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Inbound;
use App\Models\Platform\Module\Inventory;
use App\Models\Platform\Module\Inbound\Detail;
use App\Events\Platform\Inventory\Inbound\LogEvent;
use App\Events\Platform\Inventory\Inbound\FinishEvent;
use App\Events\Platform\Inventory\Inbound\AbnormalEvent;

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
      $inbound_id = $event->inbound_id;

      $inbound = Inbound::getRow(['id' => $inbound_id]);

      $detail = Detail::getList(['inbound_id' => $inbound_id]);

      foreach($detail as $item)
      {
        if(2 == $item->is_normal)
        {
          // 对比表中不存在,产品表中存在: 异常1
          event(new AbnormalEvent($inbound_id, $item->member_id, 1, $item->model, $item->code));

          continue;
        }

        $inventory = new Inventory();

        $inventory->type             = $inbound->type['value'];
        $inventory->equipment_status = $inbound->category['value'];
        $inventory->model            = $item->model;
        $inventory->code             = $item->code;
        $inventory->save();

        // 入库日志
        event(new LogEvent($inbound_id, $item->member_id, $item->code, 3));
      }
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
