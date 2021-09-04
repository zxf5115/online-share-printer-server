<?php
namespace App\Listeners\Api\Member;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Api\Member\AttentionEvent;
use App\Models\Api\Module\Member\Archive;

/**
 * 会员关注监听器
 */
class AttentionListeners
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
   * @param  AttentionEvent  $event
   * @return void
   */
  public function handle(AttentionEvent $event)
  {
    try
    {
      $status    = $event->status;
      $member_id = auth('api')->user()->id;
      $data_id   = $event->data_id;

      // 粉丝
      $model = Archive::getRow(['id' => $data_id]);

      if($status)
      {
        $model->increment('fans_total', 1);
      }
      else
      {
        if($model->fans_total > 0)
        {
          $model->decrement('fans_total', 1);
        }
      }

      // 关注
      $model = Archive::getRow(['id' => $member_id]);

      if($status)
      {
        $model->increment('attention_total', 1);
      }
      else
      {
        if($model->attention_total > 0)
        {
          $model->decrement('attention_total', 1);
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
