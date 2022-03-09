<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;

use App\TraitClass\StatisticalTrait;
use App\Models\Platform\Module\Order;
use App\Models\Platform\Module\Agent;
use App\Models\Platform\Module\Member;
use App\Models\Platform\Module\Manager;
use App\Models\Platform\Module\Printer;
use App\Models\Common\Module\Common\Area;
use App\Http\Controllers\Platform\BaseController;
use App\Models\Platform\Module\Organization\Archive;
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
      $online_total  = Printer::getCountData(1, 'activate_status');
      $offline_total = Printer::getCountData(2, 'activate_status');
      $fault_total   = Printer::getCountData(3, 'activate_status');

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

      $total        = Agent::getCountData();
      $first_total  = Agent::getCountData(1);
      $second_total = Agent::getCountData(2);

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
   * 设备状态统计数据
   * ------------------------------------------
   *
   * 设备状态统计数据
   *
   * @return [type]
   */
  public function equipment(Request $request)
  {
    try
    {
      $response = Printer::getEquipmentData();

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
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取各代理商市场销售额
   * ------------------------------------------
   *
   * 获取各代理商市场销售额
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function area(Request $request)
  {
    try
    {
      $response = [];

      $condition = self::getSimpleWhereData($request->area_id, 'province_id');

      // 获取对应区域的代理商编号
      $member_id =Archive::getPluck('member_id', $condition, false, false, true);

      if(empty($member_id))
      {
        return self::success($response);
      }

      $condition = self::getSimpleWhereData();

      $where = [
        ['id', $member_id]
      ];

      $condition = array_merge($condition, $where);

      $organization_id = Agent::getPluck('id', $condition, false, false, true);

      if(empty($organization_id))
      {
        return self::success($response);
      }

      $condition = self::getSimpleWhereData();

      $where = [
        ['first_level_agent_id', $organization_id]
      ];

      $condition = array_merge($condition, $where);

      $order = Order::getList($condition);

      if(empty($order))
      {
        return self::success($response);
      }

      foreach($order as $key => $item)
      {
        if(1 == $item->pay_status['value'])
        {
          $result[$item->first_level_agent_id][] = $item->pay_money;
        }
      }

      if(empty($result))
      {
        return self::success($response);
      }

      foreach($result as $key => $item)
      {
        $money = 0;

        foreach($item as $vo)
        {
          $money = bcadd($money, $vo, 2);
        }

        $response[] = [
          'title' => Agent::getValue('nickname', ['id' => $key]),
          '销售额' => $money,
        ];
      }

      // 提取销售额
      $value = array_column($response, '销售额');

      // 按照销量额进行从大到小排序
      array_multisort($value, SORT_DESC, $response);

      // 只返回前10位
      $response = array_slice($response, 0, 10);

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
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取各级代理商市场销售额
   * ------------------------------------------
   *
   * 获取各级代理商市场销售额
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function level(Request $request)
  {
    try
    {
      $response = [];

      $condition = self::getSimpleWhereData($request->level, 'level');

      $organization_id = Agent::getPluck('id', $condition, false, false, true);

      if(empty($organization_id))
      {
        return self::success($response);
      }

      $condition = self::getSimpleWhereData();

      if(1 == $request->level)
      {
        $field = 'first_level_agent_id';
      }
      else
      {
        $field = 'second_level_agent_id';
      }

      $where = [
        [$field, $organization_id]
      ];

      $condition = array_merge($condition, $where);

      $order = Order::getList($condition);

      if(empty($order))
      {
        return self::success($response);
      }

      foreach($order as $key => $item)
      {
        if(1 == $item->pay_status['value'])
        {
          $result[$item->$field][] = $item->pay_money;
        }
      }

      if(empty($result))
      {
        return self::success($response);
      }

      foreach($result as $key => $item)
      {
        $money = 0;

        foreach($item as $vo)
        {
          $money = bcadd($money, $vo, 2);
        }

        $response[] = [
          'title' => Agent::getValue('nickname', ['id' => $key]),
          '销售额' => $money,
        ];
      }

      // 提取销售额
      $value = array_column($response, '销售额');

      // 按照销量额进行从大到小排序
      array_multisort($value, SORT_DESC, $response);

      // 只返回前10位
      $response = array_slice($response, 0, 10);

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
