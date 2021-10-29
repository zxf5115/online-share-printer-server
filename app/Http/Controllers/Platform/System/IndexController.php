<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;

use App\TraitClass\StatisticalTrait;
use App\Models\Platform\Module\Order;
use App\Models\Platform\Module\Agent;
use App\Models\Platform\Module\Member;
use App\Models\Platform\Module\Printer;
use App\Http\Controllers\Platform\BaseController;
use App\Models\Platform\Module\Education\Courseware;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-30
 *
 * 首页控制器
 */
class IndexController extends BaseController
{
  use StatisticalTrait;

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 打印机统计数据
   * ------------------------------------------
   *
   * 打印机统计数据
   *
   * @return [type]
   */
  public function printer()
  {
    try
    {
      $response = [];

      $total         = Printer::getCountData();
      $online_total  = Printer::getCountData(1);
      $offline_total = Printer::getCountData(2);
      $fault_total   = Printer::getCountData(3);

      $response = [
        'total'         => $total,
        'online_total'  => $online_total,
        'offline_total' => $offline_total,
        'fault_total'   => $fault_total,
      ];

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 代理商数据
   * ------------------------------------------
   *
   * 代理商数据
   *
   * @return [type]
   */
  public function agent()
  {
    try
    {
      $response = [];

      $total             = Agent::getCountData();
      $first_total       = Agent::getCountData(1);
      $wait_return_total = Agent::getCountData(2);

      $response = [
        'total'        => $total,
        'first_total'  => $first_total,
        'second_total' => $second_total,
      ];

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 课程统计数据
   * ------------------------------------------
   *
   * 课程统计数据
   *
   * @return [type]
   */
  public function course()
  {
    try
    {
      $response = [];

      $online_course_total  = Courseware::getCoursewareData(1);
      $offline_course_total = Courseware::getCoursewareData(2);
      $course_total         = Courseware::getCoursewareData();

      $response = [
        'online_course_total'  => $online_course_total,
        'offline_course_total' => $offline_course_total,
        'course_total'         => $course_total,
      ];

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 会员统计数据
   * ------------------------------------------
   *
   * 会员统计数据
   *
   * @return [type]
   */
  public function member()
  {
    try
    {
      $response = [];

      $total        = Member::getMemberData();
      $manger_total = Manager::getCountData();
      $member_total = Member::getCountData();

      $response = [
        'total'        => $total,
        'manger_total' => $manger_total,
        'member_total' => $member_total,
      ];

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 订单统计数据
   * ------------------------------------------
   *
   * 订单统计数据
   *
   * @return [type]
   */
  public function data(Request $request)
  {
    try
    {
      $line = [];
      $order_total = 0;

      // 统计时间区间
      $condition = self::getWhereCondition($request->type);

      // 订单总数
      $order_total = Order::getCount($condition);

      $order = Order::getList($condition);

      $orderDate = [];

      foreach($order as $item)
      {
        $orderDate[] = date('Y-m-d', strtotime($item->create_time));
      }

      $orderDate = array_count_values($orderDate);

      foreach($orderDate as $key => $item)
      {
        $orderData[] = [
          'title' => $key,
          '订单数' => $item,
        ];
      }

      $sort = array_column($orderData, 'title');

      array_multisort($orderData, SORT_ASC, $sort);

      $response['order_total'] = $order_total;
      $response['line'] = $orderData;

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }
}
