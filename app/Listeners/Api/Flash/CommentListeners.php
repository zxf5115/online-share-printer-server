<?php
namespace App\Listeners\Api\Flash;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Api\Module\Production\Production;
use App\Events\Api\Member\Production\CommentEvent;

/**
 * 作品评论监听器
 */
class CommentListeners
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
   * @param  CommentEvent  $event
   * @return void
   */
  public function handle(CommentEvent $event)
  {
    try
    {
      $production_id = $event->production_id;

      $production = Production::getRow(['id' => $production_id]);

      $production->increment('comment_total', 1);

      $production->save();

      return true;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
