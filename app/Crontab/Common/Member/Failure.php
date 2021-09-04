<?php
namespace App\Crontab\Common\Member;

use Illuminate\Routing\Controller;
use App\Models\Common\Module\Member\Vip;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 会员贵宾失效定时任务
 */
class Failure extends Controller
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 检测会员VIP是否到期，到期自动变更为普通会员
   * ------------------------------------------
   *
   * 检测会员VIP是否到期，到期自动变更为普通会员
   *
   * @return [type]
   */
  public function action()
  {
    try
    {
      $where = [
        'status' => 1,
        ['vip_id', '!=', 1],
        ['end_time', '<', time()]
      ];

      $model = Vip::getList($where);

      foreach($model as $item)
      {
        $item->vip_id = 1;
        $item->save();
      }
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
