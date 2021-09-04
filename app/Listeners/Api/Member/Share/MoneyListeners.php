<?php
namespace App\Listeners\Api\Member\Share;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Api\System\Config;
use App\Events\Api\Member\Share\MoneyEvent;
use App\Models\Api\Module\Member\Relevance\Course;
use App\Models\Api\Module\Education\Courseware\Courseware;
use App\Models\Api\Module\Teacher\Recruitment\Relevance\Money;
use App\Models\Api\Module\Teacher\Recruitment\Relevance\Relevance\Obtain;

/**
 * 老师分红监听器
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
      $course_id     = $event->course_id;
      $courseware_id = $event->courseware_id;
      $level_id      = $event->level_id;
      $member_id     = $event->member_id;

      // 获取体验课id
      $courseware_id = Config::getConfigValue('trial_class');

      $where = [
        'member_id'     => $member_id,
        'courseware_id' => $courseware_id,
      ];

      // 获取当前学员购买体验课信息
      $order = Course::getRow($where);

      // 如果当前学员没有购买过体验课
      if(empty($order))
      {
        return false;
      }

      $teacher_id = $order->teacher_id;

      // 分红金额
      $money = Config::getConfigValue('student_buy_course');

      $model = Money::firstOrCreate(['member_id' => $teacher_id]);
      $model->increment('wait_money', $money);
      $model->increment('wait_number', 1);
      $model->increment('total_money', $money);
      $model->increment('total_number', 1);
      $model->save();

      $obtain = new Obtain();
      $obtain->member_id     = $teacher_id;
      $obtain->course_id     = $course_id;
      $obtain->courseware_id = $courseware_id;
      $obtain->level_id      = $level_id;
      $obtain->money         = $money;
      $obtain->save();

      return true;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
