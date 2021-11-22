<?php
namespace App\Listeners\Platform\Inventory\Outbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Organization;
use App\Models\Platform\Module\Inventory\Log;
use App\Events\Platform\Inventory\Outbound\LogEvent;

/**
 * 出库日志监听器
 */
class LogListeners
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
   * @param  LogEvent  $event
   * @return void
   */
  public function handle(LogEvent $event)
  {
    try
    {
      $inventory_id = $event->inventory_id;
      $member_id    = $event->member_id;
      $code         = $event->code;
      $status       = $event->status;

      $operator = auth('platform')->user()->nickname;
      $content  = '出库操作: ';
      $message  = '预出库';

      $current_time = date('Y-m-d H:i:s');

      // 代理商姓名
      $nickname = Organization::getOrganizationName($member_id);

      if(3 == $status)
      {
        $message = '出库';
      }

      $content = $content .
                 $operator .
                 ' 在 ' .
                 $current_time .
                 ' 将设备编号(' . $code .') 的设备' .
                 $message .
                 ' 给 ' .
                 $nickname;

      $model = new Log();

      $model->inventory_id = $inventory_id;
      $model->content      = $content;
      $model->operator     = $operator;
      $model->save();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
