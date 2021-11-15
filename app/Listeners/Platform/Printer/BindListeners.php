<?php
namespace App\Listeners\Platform\Printer;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Printer;
use App\Events\Platform\Printer\BindEvent;
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
        $where = [
          'id' => $item->printer_id,
          'bind_status' => 2
        ];

        $model = Printer::getRow($where);

        if(1 == $type)
        {
          $model->first_level_agent_id = $item->member_id;
        }
        else
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
