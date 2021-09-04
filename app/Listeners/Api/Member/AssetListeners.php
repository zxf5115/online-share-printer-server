<?php
namespace App\Listeners\Api\Member;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Api\Member\AssetEvent;
use App\Models\Api\Module\Member\Asset;

/**
 * 金额监听器
 */
class AssetListeners
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
   * @param  AssetEvent  $event
   * @return void
   */
  public function handle(AssetEvent $event)
  {
    try
    {
      $member_id = $event->member_id;
      $money     = $event->money;
      $type      = $event->type;

      if(1 == $type)
      {
        $asset = Asset::firstOrCreate(['member_id' => $member_id]);
        $asset->increment('money', $money);
        $asset->save();
      }
      else
      {
        $asset = Asset::firstOrCreate(['member_id' => $member_id]);
        $asset->decrement('money', $money);
        $asset->save();
      }

      return true;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
