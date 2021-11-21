<?php
namespace App\Models\Common\System;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

use App\Models\Base;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-14
 *
 * 文件模型
 */
class File extends Base
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-21
   * ------------------------------------------
   * 下载文件
   * ------------------------------------------
   *
   * 下载文件
   *
   * @param [type] $url 文件地址
   * @param string $path 保存目录
   * @return [type]
   */
  public static function download($url, $path = 'download')
  {
    try
    {
      $client = new Client(['verify' => false]);

      $file = $client->request('get', $url)->getBody()->getContents();

      // 过滤所有的.符号
      $path = str_replace('.', '', $path);

        // 先去除两边空格
      $path = trim($path, '/');

        // 获取文件后缀
      $extension = pathinfo($url, PATHINFO_EXTENSION);

      // 组合新的文件名
      $filename = md5(time()) . '.' . $extension;

      $dir = $path . DIRECTORY_SEPARATOR . date('Y-m-d');

      $filename = $dir . DIRECTORY_SEPARATOR . $filename;

      if(Storage::disk('public')->put($filename, $file))
      {
        return Storage::url($filename);
      }
      else
      {
        return false;
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
   * @dateTime 2021-11-21
   * ------------------------------------------
   * 删除本地文件
   * ------------------------------------------
   *
   * 删除本地文件
   *
   * @return [type]
   */
  public static function destroy($url)
  {
    return Storage::disk('public')->delete($url);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-21
   * ------------------------------------------
   * 获得物理路径
   * ------------------------------------------
   *
   * 获得物理路径
   *
   * @param [type] $url 本地地址
   * @return [type]
   */
  public static function getPhysicalUrl($url)
  {
    $url = str_replace('storage', '/storage/app/public', $url);

    return base_path(trim($url, '/'));
  }
}
