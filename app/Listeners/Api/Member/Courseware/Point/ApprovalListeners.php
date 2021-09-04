<?php
namespace App\Listeners\Api\Member\Courseware\Point;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Common\Module\Member\Archive;
use App\Models\Api\Module\Education\Courseware\Point;
use App\Events\Api\Member\Courseware\Point\ApprovalEvent;

/**
 * 课程知识点点赞监听器
 */
class ApprovalListeners
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
   * @param  ApprovalEvent  $event
   * @return void
   */
  public function handle(ApprovalEvent $event)
  {
    try
    {
      $status = $event->status;

      $data_id = $event->data_id;

      $member_id = auth('api')->user()->id;

      $archive = Archive::firstOrNew(['member_id' => $member_id]);

      $point = Point::getRow(['id' => $data_id]);

      if(empty($point))
      {
        return false;
      }

      if($status)
      {
        $archive->increment('approval_total', 1);
        $point->increment('approval_total', 1);
      }
      else
      {
        if($archive->approval_total > 0)
        {
          $archive->decrement('approval_total', 1);
        }

        if($point->approval_total > 0)
        {
          $point->decrement('approval_total', 1);
        }
      }

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
