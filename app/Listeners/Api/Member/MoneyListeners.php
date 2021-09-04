<?php
namespace App\Listeners\Api\Member;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Api\Member\MoneyEvent;
use App\Models\Api\Module\Member\Money;

/**
 * 金额流向监听器
 */
class MoneyListeners
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
   * @param  MoneyEvent  $event
   * @return void
   */
  public function handle(MoneyEvent $event)
  {
    try
    {
      $member_id = $event->member_id;
      $money     = $event->money;
      $type      = $event->type;

      $model = Money::firstOrNew(['id' => 0]);

      $model->member_id = $member_id;
      $model->type      = $type;
      $model->money     = $money;
      $model->confirm_status = $type == 2 ? 1 : 2;
      $model->save();

      return true;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
