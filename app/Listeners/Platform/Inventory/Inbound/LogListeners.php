<?php
namespace App\Listeners\Platform\Inventory\Inbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Platform\Module\Organization;
use App\Models\Platform\Module\Inventory\Log;
use App\Events\Platform\Inventory\Inbound\LogEvent;

/**
 * 库存日志监听器
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
      $status       = $event->status;
      $type         = $event->type;

      $content = '入库操作: ';
      $message = '预出库处理';

      $current_time = date('Y-m-d H:i:s');

      // 代理商姓名
      $nickname = Organization::getOrganizationName($member_id);

      if(2 == $type)
      {
        $content = '出库操作: ';
      }

      if(3 == $status)
      {
        $message = '';
      }

      $content = $content . $current_time . ' 将设备做 ' . $nickname


      $model = new Log();

      $model->inventory_id = $inventory_id;
      $model->content      = $content;
      $model->operator     = auth('platform')->user()->nickname;
      $model->save();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
