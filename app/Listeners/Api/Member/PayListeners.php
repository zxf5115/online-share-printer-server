<?php
namespace App\Listeners\Api\Member;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Api\Member\PayEvent;

use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Exceptions\GatewayException;

/**
 * 支付监听器
 */
class PayListeners
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
   * @param  PayEvent  $event
   * @return void
   */
  public function handle(PayEvent $event)
  {
    try
    {
      $response = null;

      // 订单信息
      $order = $event->order;

      if(empty($order))
      {
        return false;
      }

      $type = $order->pay_type['value'];

      // 微信支付
      if(2 == $type)
      {
        $response = $this->wechat($order);
      }
      // 支付宝支付
      else if(1 == $type)
      {
        $response = $this->alipay($order);
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
   * @dateTime 2021-02-19
   * ------------------------------------------
   * 微信支付
   * ------------------------------------------
   *
   * 微信支付
   *
   * @return [type]
   */
  private function wechat($order, $is_h5 = false)
  {
    try
    {
      $pay_money = intval(bcmul($order->money, 100));

      $data = [
        'out_trade_no' => $order->id,
        'body'         => '订单支付',
        'total_fee'    => $pay_money
      ];

      $config  = config('pay.wechat');

      $result = Pay::wechat($config)->app($data);

      $content = $result->getContent() ?? '';

      $response = json_decode($content, true) ?? [];

      return $response;
    }
    catch (GatewayException $e)
    {
      Log::info(date("H:i:s") . " 订单{order['out_trade_no']}");

      if (strpos($e->getMessage(), 'OK该订单已支付') === false)
      {
        // 不是已支付订单
        Log::error($e->getMessage());
      }
      else
      {
        // 订单已支付消息;
      }
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-02-19
   * ------------------------------------------
   * 支付宝支付
   * ------------------------------------------
   *
   * 支付宝支付
   *
   * @return [type]
   */
  private function alipay($order, $is_h5 = false)
  {
    try
    {
      $data = [
        'out_trade_no' => $order->id,
        'subject'      => '订单支付',
        'total_amount' => $order->money
      ];

      $config  = config('pay.alipay');

      $result = Pay::alipay($config)->app($data);

      $response = $result->getContent() ?? '';

      return $response;
    }
    catch (GatewayException $e)
    {
      Log::info(date("H:i:s") . " 订单{order['out_trade_no']}");

      if (strpos($e->getMessage(), 'OK该订单已支付') === false)
      {
        // 不是已支付订单
        Log::error($e->getMessage());
      }
      else
      {
        // 订单已支付消息;
      }
    }
  }
}
