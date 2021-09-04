<?php
namespace App\Listeners\Api\Member\Information;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Api\Module\Project;
use App\Events\Api\Member\Information\CollectionEvent;

/**
 * 项目收藏监听器
 */
class CollectionListeners
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
   * @param  CollectionEvent  $event
   * @return void
   */
  public function handle(CollectionEvent $event)
  {
    try
    {
      $type       = $event->type;
      $project_id = $event->project_id;

      $project = Project::getRow(['id' => $project_id]);

      if(1 == $type)
      {
        $project->increment('collection_total', 1);
      }
      else
      {
        if($project->approval_total > 0)
        {
          $project->decrement('collection_total', 1);
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
