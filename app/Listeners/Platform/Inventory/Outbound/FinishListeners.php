<?php
namespace App\Listeners\Platform\Inventory\Outbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Printer;
use App\Models\Platform\Module\Inventory;
use App\Models\Platform\Module\Organization;
use App\Models\Platform\Module\Outbound\Detail;
use App\Events\Platform\Inventory\Outbound\LogEvent;
use App\Events\Platform\Inventory\Outbound\FinishEvent;
use App\Events\Platform\Organization\Asset\Printer\TotalEvent;

/**
 * 出库完成监听器
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
      $outbound_id = $event->outbound_id;

      $result = Detail::getList(['outbound_id' => $outbound_id]);

      foreach($result as $item)
      {
        $first_level_agent_id  = 0;
        $second_level_agent_id = 0;

        $inventory = Inventory::getRow(['code' => $item->code]);
        $inventory->inventory_status = 3;
        $inventory->save();

        // 出库日志
        event(new LogEvent($inventory->id, $item->member_id, $item->code, 3));


        $member = Organization::getRow(['status' => 1, 'id' => $item->member_id]);

        $level = $member->level;

        $printer = Printer::firstOrNew(['code' => $item->code]);

        $printer->model = $item->model;
        $printer->code  = $item->code;

        if(empty($level['value']))
        {
          continue;
        }
        else if(1 == $level['value'])
        {
          $printer->first_level_agent_id = $item->member_id;
        }
        else if(2 == $level['value'])
        {
          $printer->second_level_agent_id = $item->member_id;
        }

        $printer->save();

        // 添加实际接受打印机数量
        event(new TotalEvent($item->member_id));
      }
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
