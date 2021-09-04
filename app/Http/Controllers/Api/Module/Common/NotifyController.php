z<?php
namespace App\Http\Controllers\Api\Module\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;
use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;
use Yansongda\Pay\Exceptions\GatewayException;

use App\Events\Api\Member\AssetEvent;
use App\Models\Common\Module\Member\Money;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-02-19
 *
 * 回调控制器类
 */
class NotifyController extends BaseController
{

  /**
   * @api {post} /api/common/notify/wechat 14. 微信支付回调
   * @apiDescription 获取微信支付回调
   * @apiGroup 02. 公共模块
   *
   * @apiSampleRequest /api/common/notify/wechat
   * @apiVersion 1.0.0
   */
  public function wechat(Request $request)
  {
    DB::beginTransaction();

    try
    {
      Log::info('微信支付回调开始 <================ 支付中');

      $config = config('pay.wechat');

      $pay = Pay::wechat($config);

      $data = $pay->verify(); // 验签

      Log::debug('微信回调参数', $data->all());

      $order_no = $data->out_trade_no;

      Log::info('订单编号====' . $order_no);

      $where = [
        'id'     => $order_no,
        'status' => 1
      ];

      $model = Money::getRow($where);

      if(empty($model->id))
      {
        return false;
      }

      $model->confirm_status = 1;
      $model->save();

      // 充值
      event(new AssetEvent($model->member_id, $model->money));

      Log::info('支付成功');

      DB::commit();

      return $pay->success()->send();
    }
    catch(\Exception $e)
    {
      DB::rollback();

      $content = '在文件 ' . $e->getFile();
      $content .= ' 的 ' . $e->getLine();
      $content .= ' 行 ' .$e->getMessage();

      Log::info('支付失败====' . $content);
    }
  }


  /**
   * @api {post} /api/common/notify/alipay 15. 支付宝支付回调
   * @apiDescription 获取支付宝支付回调
   * @apiGroup 02. 公共模块
   *
   * @apiSampleRequest /api/common/notify/alipay
   * @apiVersion 1.0.0
   */
  public function alipay(Request $request)
  {
    try
    {
      Log::info('支付宝支付回调开始 <================ 支付中');

      $config = config('pay.alipay');

      $alipay = Pay::alipay($config);

      $data = $alipay->verify(); // 验签

      Log::debug('支付宝回调参数', $data->all());

      $order_no = $data->out_trade_no;

      Log::info('订单编号====' . $order_no);

      $where = [
        'id'     => $order_no,
        'status' => 1
      ];

      $model = Money::getRow($where);

      if(empty($model->id))
      {
        return false;
      }

      $model->confirm_status = 1;
      $model->save();

      // 充值
      event(new AssetEvent($model->member_id, $model->money));

      Log::info('支付成功');

      DB::commit();

      return $alipay->success()->send();
    }
    catch(\Exception $e)
    {
      DB::rollback();

      $content = '在文件 ' . $e->getFile();
      $content .= ' 的 ' . $e->getLine();
      $content .= ' 行 ' .$e->getMessage();

      Log::info('支付失败====' . $content);
    }
  }


  /**
   * @api {post} /api/common/notify/apple 16. 苹果支付回调
   * @apiDescription 获取微信支付回调
   * @apiGroup 02. 公共模块
   *
   * @apiParam {int} order_no 订单号(创建支付订单id)
   * @apiParam {int} is_box 是否为沙盒
   * @apiParam {int} receipt 苹果凭证
   *
   * @apiSampleRequest /api/common/notify/apple
   * @apiVersion 1.0.0
   */
  public function apple(Request $request)
  {
    $messages = [
      'money.required'   => '请您输入订单号',
      'receipt.required' => '请您输入苹果凭证',
    ];

    $rule = [
      'money'   => 'required',
      'receipt' => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $order_no = $request->order_no;

        $receipt  = $request->receipt;

        $is_box  = $request->is_box;

        $where = [
          'id'     => $order_no,
          'status' => 1
        ];

        $model = Money::getRow($where);

        if(empty($model->id))
        {
          return false;
        }

        $url = getenv('APPLE_PAY_URL');

        if($is_box)
        {
          $url = getenv('APPLE_TEST_PAY_URL');
        }

        $data = json_encode(['receipt-data' => $receipt])

        /**
         * 21000 App Store不能读取你提供的JSON对象
         * 21002 receipt-data域的数据有问题
         * 21003 receipt无法通过验证
         * 21004 提供的shared secret不匹配你账号中的shared secret
         * 21005 receipt服务器当前不可用
         * 21006 receipt合法，但是订阅已过期。服务器接收到这个状态码时，receipt数据仍然会解码并一起发送
         * 21007 receipt是Sandbox receipt，但却发送至生产系统的验证服务
         * 21008 receipt是生产receipt，但却发送至Sandbox环境的验证服务
         * https://blog.csdn.net/createNo_1/article/details/80109012
         */
        $response = curl($url, $data);

        $result = json_decode($response, true);

        if(0 !== intval($result['status']))
        {
          return self::error(Code::PAY_ERROR);
        }

        $model->confirm_status = 1;
        $model->save();

        // 充值
        event(new AssetEvent($model->member_id, $model->money));

        Log::info('支付成功');

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
