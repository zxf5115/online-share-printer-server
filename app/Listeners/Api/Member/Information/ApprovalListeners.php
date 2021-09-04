<?php
namespace App\Listeners\Api\Member\Information;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Api\Module\Information;
use App\Models\Api\Module\Member\Archive;
use App\Events\Api\Member\Information\ApprovalEvent;

/**
 * 资讯点赞监听器
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

      $information = Information::getRow(['id' => $data_id]);

      if($status)
      {
        $archive->increment('approval_total', 1);
        $information->increment('approval_total', 1);
      }
      else
      {
        if($archive->approval_total > 0)
        {
          $archive->decrement('approval_total', 1);
        }

        if($information->approval_total > 0)
        {
          $information->decrement('approval_total', 1);
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
