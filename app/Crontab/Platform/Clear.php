<?php
namespace App\Crontab\Platform;

use Illuminate\Routing\Controller;
use App\Models\Platform\System\Log\Action;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-08
 *
 * 清除数据定时任务
 */
class Clear extends Controller
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-08-26
   * ------------------------------------------
   * 行为日志定时清除（行为日志只保存1个月）
   * ------------------------------------------
   *
   * 按照配置时间统计每位司机的工资
   *
   * @return [type]
   */
  public function action()
  {
    try
    {
      // 清除结束时间点
      $timestamp = strtotime('-3 month');

      // 清除行为日志信息
      Action::where([['create_time', '<', $timestamp]])->delete();
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }
}
