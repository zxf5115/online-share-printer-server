<?php
namespace App\Crontab\Common\Flash;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use zxf5115\Upload\File;
use App\Models\Common\Module\Flash;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-12
 *
 * 快讯爬虫定时任务
 */
class Crawler extends Controller
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-12
   * ------------------------------------------
   * 爬取金色财经快讯信息
   * ------------------------------------------
   *
   * 爬取金色财经快讯信息
   *
   * @return [type]
   */
  public function action()
  {
    try
    {
      $img = 'https://img.jinse.com/jinse_1626082788869889021_live-rb.png';

      $url = getenv('GOLDEN_FINANCE_URL');

      $http = new Client();

      $response = $http->get($url);

      if(200 == $response->getStatusCode())
      {
        $content = $response->getBody()->getContents();

        $result = json_decode($content, true);

        if(empty($result['list']) && empty($result['list'][0]['lives']))
        {
          return false;
        }

        $data = $result['list'][0]['lives'];

        foreach($data as $item)
        {
          $where = [
            'title' => $item['content_prefix']
          ];

          $flash = Flash::getRow($where);

          // 如果已存在标题一致的数据，跳过
          if(!empty($flash->id))
          {
            continue;
          }

          $content = $item['content'];

          // 保存图片信息
          if(!empty($item['images']))
          {
            foreach($item['images'] as $vo)
            {
              $data = $this->getImageBase64Data($vo['url']);

              $url = File::picture_base64($data, 'flash');

              $picture = '<img src="'.$url.'" style="width: 300px;" class="fr-fic fr-dii">';

              $content = $content . $picture;
            }
          }

          Flash::firstOrCreate([
            'category_id' => 1,
            'user_id'     => 1,
            'title'       => $item['content_prefix'],
            'content'     => $content,
            'create_time' => $item['created_at'],
          ]);
        }
      }
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-12
   * ------------------------------------------
   * 将图片转化为base64文件
   * ------------------------------------------
   *
   * 将图片转化为base64文件
   *
   * @param [type] $url [description]
   * @return [type]
   */
  private function getImageBase64Data($url)
  {
    try
    {
      $imageInfo = getimagesize($url);

      $base64 = "" . chunk_split(base64_encode(file_get_contents($url)));

      return 'data:' . $imageInfo['mime'] . ';base64,' . $base64;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
