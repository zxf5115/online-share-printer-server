<?php
namespace App\Listeners\Platform\Printer;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Printer;
use App\Events\Platform\Printer\BindEvent;
use App\Models\Platform\Module\Organization;
use App\Models\Platform\Module\Outbound\Detail;

/**
 * 设备绑定监听器
 */
class BindListeners
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
   * @param  BindEvent  $event
   * @return void
   */
  public function handle(BindEvent $event)
  {
    try
    {
      $outbound_id = $event->outbound_id;

      $result = Detail::getList(['outbound_id' => $outbound_id]);

      foreach($result as $item)
      {
        $model = Printer::getRow(['id' => $item->printer_id, 'bind_status' => 2]);

        $member = Organization::getRow(['status' => 1, 'id' => $item->member_id]);

        $level = $member->level;

        if(empty($level['value']))
        {
          continue;
        }
        else if(1 == $level['value'])
        {
          $model->first_level_agent_id = $item->member_id;
        }
        else if(2 == $level['value'])
        {
          $model->second_level_agent_id = $item->member_id;
        }

        $model->bind_status = 1;
        $model->save();
      }
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
