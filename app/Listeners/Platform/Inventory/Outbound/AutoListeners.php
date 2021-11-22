<?php
namespace App\Listeners\Platform\Inventory\Outbound;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Common\System\File;
use App\Models\Platform\Module\Outbound;
use App\Imports\Outbound\EquipmentImport;
use App\Models\Platform\Module\Outbound\Resource;
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
      $member_id     = $event->member_id;
      $total         = $event->total;
      $equipment_url = $event->equipment_url;

      $model = new Outbound();

      $model->type      = 1;
      $model->category  = 1;
      $model->member_id = $member_id;
      $model->total     = $total;
      $model->save();

      // 如果是二级分销商，一级分销商提供设备文档
      if(!empty($equipment_url))
      {
        // 出库文件资源
        $resource = Resource::firstOrNew(['outbound_id' => $model->id]);

        $resource->device_code = $equipment_url;
        $resource->save();

        $url = File::download($equipment_url);

        $url = File::getPhysicalUrl($url);

        // 导入设备数据
        Excel::import(new EquipmentImport($model->id, $member_id), $url);

        File::destroy($url);
      }


    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
