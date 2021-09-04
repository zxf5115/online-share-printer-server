<?php
namespace App\Crontab\Platform\Currency;

use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller;
use App\Models\Common\Module\Currency\Symbol as SymbolModel;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币交易定时任务
 */
class Symbol extends Controller
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-27
   * ------------------------------------------
   * 采集货币信息
   * ------------------------------------------
   *
   * 采集货币信息
   *
   * @return [type]
   */
  public function action()
  {
    DB::beginTransaction();

    try
    {
      $api_key = getenv('CURRENCY_API_KEY');
      $url = getenv('CURRENCY_SYMBOL_URL');

      for($i = 0; $i < 50; $i++)
      {
        $params = [
          'api_key' => $api_key,
          'size'    => 100,
          'page'    => $i
        ];

        $param = http_build_query($params);

        $url = $url . '?' . $param;

        $result = json_decode($this->curl($url));

        if(empty($result))
        {
          return false;
        }

        foreach($result as $item)
        {
          $model = SymbolModel::firstOrNew(['symbol' => $item->m]);

          // 将已存在的货币去除
          if(!empty($model->id))
          {
            continue;
          }

          $data = explode('_', $item->m);

          $model->market         = $data[0] ?? '';
          $model->symbol         = $item->m ?? '';
          $model->base_currency  = $data[1] ?? '';
          $model->quote_currency = $data[2] ?? '';
          $model->save();
        }
      }

      DB::commit();
    }
    catch(\Exception $e)
    {
      DB::rollback();

      record($e);

      return false;
    }
  }





  private function curl($url, $is_post = false, $postdata=[])
  {
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);

    if($is_post)
    {
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
    }

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_TIMEOUT,60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json",]);

    if(curl_exec($ch) === false)
    {
       echo 'Curl error: ' . curl_error($ch);
    }
    else
    {
      $output = curl_exec($ch);

      $info = curl_getinfo($ch);

      return $output;
    }

    curl_close($ch);
  }




  private function initSocket()
  {
    try
    {
      $client = new \WebSocket\Client("wss://api.huobi.pro/ws");

      $data = [
        'sub' => 'market.btcusdt.detail',
        'id' => "btcusdtdetail" . time(),
        ''
      ];

      $data = json_encode($data);

      $client->send($data);

      while (true)
      {
        try
        {

          $response = $client->receive();

          $response = gzdecode($response);

          $response = json_decode($response, true);

          if(isset($response['ping']))
          {
            $data = [
                "pong" => $response['ping']
            ];

            $data = json_encode($data);

            $client->send($data);
          }
          else
          {
            \Log::error($response);

            // if(!empty($response['status']) && 'ok' == $response['status'])
            // {
            //   if(!empty($response['data']))
            //   {
            //     \Log::error($response['data']);
            //   }
            // }
          }
        }
        catch (\WebSocket\ConnectionException $e)
        {
          continue;
        }
      }


      $client->close();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
