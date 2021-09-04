<?php
namespace App\Listeners\Api\Member;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Api\Member\CoursewareEvent;
use App\Models\Api\Module\Member\Courseware;

/**
 * 会员课程监听器
 */
class CoursewareListeners
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
   * @param  CoursewareEvent  $event
   * @return void
   */
  public function handle(CoursewareEvent $event)
  {
    try
    {
      $member_id = $event->member_id;

      $courseware_id   = $event->courseware_id;

      $source = $event->source;

      // 会员课程
      foreach($courseware_id as $item)
      {
        $model = Courseware::firstOrNew([
          'member_id'     => $member_id,
          'courseware_id' => $item,
        ]);

        $model->source = $source;
        $model->save();
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
