<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Order as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-29
 *
 * 订单模型类
 */
class Order extends Common
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取订单支付总金额数据
   * ------------------------------------------
   *
   * 获取订单支付总金额数据
   *
   * @param [type] $where [description]
   * @return [type]
   */
  public static function getPayMoneyData($where)
  {
    try
    {
      $response = 0.00;

      $result = self::getList($where);

      if(!empty($result))
      {
        foreach($result as $item)
        {
          $response = bcadd($response, $item->pay_money, 2);
        }
      }

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取待支付订单总数
   * ------------------------------------------
   *
   * 获取待支付订单总数
   *
   * @return [type]
   */
  public static function getWaitPayData()
  {
    try
    {
      $response = 0;

      $where = [
        'status'     => 1,
        'pay_status' => 0,
        [
          'order_status', '!=', 3
        ]
      ];

      $response = self::getCount($where);

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取待确认订单数据
   * ------------------------------------------
   *
   * 获取待确认订单数据
   *
   * @return [type]
   */
  public static function getConfirmPayData()
  {
    try
    {
      $response = 0;

      $where = [
        'status'       => 1,
        'pay_status'   => 1,
        'order_status' => 2
      ];

      $response = self::getCount($where);

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取待退款订单数据
   * ------------------------------------------
   *
   * 获取待退款订单数据
   *
   * @return [type]
   */
  public static function getRefundPayData()
  {
    try
    {
      $response = 0;

      $where = [
        'status'       => 1,
        'pay_status'   => 1,
        'order_status' => 4
      ];

      $response = self::getCount($where);

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
