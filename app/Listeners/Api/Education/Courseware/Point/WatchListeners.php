<?php
namespace App\Listeners\Api\Education\Courseware\Point;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Api\Module\Education\Courseware\Point;
use App\Events\Api\Education\Courseware\Point\WatchEvent;

/**
 * 课程知识点浏览监听器
 */
class WatchListeners
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  WatchEvent  $event
   * @return void
   */
  public function handle(WatchEvent $event)
  {
    try
    {
      $data_id   = $event->data_id;

      $point = Point::getRow(['id' => $data_id]);

      $model = $point->courseware;

      $model->increment('watch_total', 1);

      return true;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
