<?php
namespace App\Crontab\Platform\Currency;

use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller;
use App\Models\Common\Module\Currency\Category as CategoryModel;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-27
 *
 * 货币种类定时任务
 */
class Category extends Controller
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
      $url = getenv('CURRENCY_CATEGORY_URL');

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
          $model = CategoryModel::firstOrNew(['slug' => $item->slug]);

          // 将已存在的货币去除
          if(!empty($model->id))
          {
            continue;
          }

          // 将已停止更新的货币去除
          if('disable' == $item->status)
          {
            continue;
          }

          $model->slug             = $item->slug ?? '';
          $model->symbol           = $item->symbol ?? '';
          $model->fullname         = $item->fullname ?? '';
          $model->logo_url         = $item->logoUrl ?? '';
          $model->market_cap_usd   = $item->marketCapUsd ?? '';
          $model->available_supply = $item->availableSupply ?? '';
          $model->total_supply     = $item->totalSupply ?? '';
          $model->max_supply       = $item->maxSupply ?? '';
          $model->issue_time       = strtotime($item->issueDate);
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
}
