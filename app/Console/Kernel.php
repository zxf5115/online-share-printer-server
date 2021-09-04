<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Crontab\Platform\Clear;
use App\Crontab\Common\Flash\Crawler;
use App\Models\Platform\System\Config;
use App\Crontab\Common\Member\Failure;
use App\Crontab\Platform\Currency\Symbol;
use App\Crontab\Platform\Currency\Bourse;
use App\Crontab\Platform\Currency\Category;

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

      // // 清除失效贵宾数据
      $schedule->call(function () {
        $clear = new Failure();
        $clear->action();
      })->everyMinute();


      // 抓取金色财经数据
      $schedule->call(function () {
        $clear = new Crawler();
        $clear->action();
      })->hourly();


      // // 定时获取货币交易对
      $schedule->call(function () {
        $currency = new Symbol();
        $currency->action();
      })->yearly();


      // 定时获取货币种类
      $schedule->call(function () {
        $currency = new Category();
        $currency->action();
      })->yearly();


      // 定时获取货币交易所
      // $schedule->call(function () {
      //   $clear = new Bourse();
      //   $clear->action();
      // })->yearly();
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
