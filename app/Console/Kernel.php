<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Crontab\Platform\Clear;
use App\Models\Platform\System\Config;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
      //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    try
    {
      // 清除日期（每月几号）
      $clear_time = Config::getConfigValue('clear_time');

      // 清除平台数据
      $schedule->call(function () {
        $clear = new Clear();
        $clear->action();
      })->monthlyOn($clear_time, '04:00');
    }
    catch(\Exception $e)
    {
      record($e);
    }
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__.'/Commands');

    require base_path('routes/console.php');
  }
}
