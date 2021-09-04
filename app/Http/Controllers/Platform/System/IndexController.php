<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;

use App\TraitClass\StatisticalTrait;
use App\Models\Platform\Module\Order;
use App\Models\Platform\Module\Member;
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
   * 订单统计数据
   * ------------------------------------------
   *
   * 订单统计数据
   *
   * @return [type]
   */
  public function order()
  {
    try
    {
      $response = [];

      $today_order_total     = Order::getPayMoneyData(self::getWhereCondition(1));
      $yesterday_order_total = Order::getPayMoneyData(self::getWhereCondition(2));
      $week_order_total      = Order::getPayMoneyData(self::getWhereCondition(3));
      $month_order_total     = Order::getPayMoneyData(self::getWhereCondition(4));

      $response = [
        'today_order_total' => $today_order_total,
        'yesterday_order_total' => $yesterday_order_total,
        'week_order_total' => $week_order_total,
        'month_order_total' => $month_order_total,
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
   * 待处理订单数据
   * ------------------------------------------
   *
   * 待处理订单数据
   *
   * @return [type]
   */
  public function todo()
  {
    try
    {
      $response = [];

      $wait_pay_total     = Order::getWaitPayData();
      $wait_confirm_total = Order::getConfirmPayData();
      $wait_return_total  = Order::getRefundPayData();

      $response = [
        'wait_pay_total'     => $wait_pay_total,
        'wait_confirm_total' => $wait_confirm_total,
        'wait_return_total'  => $wait_return_total,
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

      $today_member_total     = Member::getMemberData(self::getWhereCondition(1));
      $yesterday_member_total = Member::getMemberData(self::getWhereCondition(2));
      $month_order_total      = Member::getMemberData(self::getWhereCondition(4));
      $member_total           = Member::getMemberData(self::getWhereCondition(8));

      $response = [
        'today_member_total'     => $today_member_total,
        'yesterday_member_total' => $yesterday_member_total,
        'month_order_total'      => $month_order_total,
        'member_total'           => $member_total,
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
