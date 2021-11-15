<?php
namespace App\Models\Common\System;

use Illuminate\Support\Facades\Storage;

use App\Models\Base;
use App\Http\Constant\Code;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-14
 *
 * 文件上传模型
 */
class File extends Base
{
  public $ossClient = null;

  public $req = null;

  public $data = [];

  /**
   * 允许类型
   */
  public $allow = ['jpeg','png','gif','jpg'];

  /**
   * 水印图片地址
   */
  public $water = '';

  /**
   * 保存目录
   */
  public $dir = '/shop/';

  /**
   * 图片宽度
   */
  public $width = 800;

  /**
   * 图片高度
   */
  public $height = 600;



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-24
   * ------------------------------------------
   * 上传图片
   * ------------------------------------------
   *
   * 上传图片
   *
   * @param string $name 文件名
   * @param string $path 路径
   * @param boolean $type 是否支持上传服务器，默认不上传
   * @param string $disk 用那种方式上传 oss, cos, qiniu, 又拍云
   * @param array $extension 允许上传的后缀
   * @return [type]
   */
  public static function image($name, $path = 'uploads', $disk = 'public', $extension = [])
  {
    $allowExtension = [
      'jpg',
      'jpeg',
      'png',
      'gif',
      'bmp'
    ];

    if($extension)
      $allowExtension = array_merge($allowExtension, $extension);

    return self::file($name, $path, $disk, $allowExtension);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-24
   * ------------------------------------------
   * 上传PDF
   * ------------------------------------------
   *
   * 上传PDF
   *
   * @param string $name 文件名
   * @param string $path 路径
   * @param boolean $type 是否支持上传服务器，默认不上传
   * @param string $disk 用那种方式上传 oss, cos, qiniu, 又拍云
   * @param array $extension 允许上传的后缀
   * @return [type]
   */
  public static function pdf($name, $path = 'uploads', $disk = 'public', $extension = [])
  {
    return self::file($name, $path, $disk);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-24
   * ------------------------------------------
   * 上传文件
   * ------------------------------------------
   *
   * 上传文件
   *
   * @param string $name 文件名
   * @param string $path 路径
   * @param string $disk 用那种方式上传 oss, cos, qiniu, 又拍云
   * @param array $extension 允许上传的后缀
   * @return [type]
   */
  public static function file($name, $path = 'uploads', $disk = 'public', $allowExtension = [])
  {
    if (!request()->hasFile($name))
    {
      return [
        'status' => Code::FILE_UPLOAD_EXIST,
        'message' => Code::$message[Code::FILE_UPLOAD_EXIST]
      ];
    }

    $file = request()->file($name);

    if(!$file->isValid())
    {
      return [
        'status' => Code::FILE_UPLOAD_FAILURE_RETRY,
        'message' => Code::$message[Code::FILE_UPLOAD_FAILURE_RETRY]
      ];
    }

    $category_id = Config::isLocalStorage();

    if($category_id)
    {
      $data = Config::getConfigData($category_id);

      $access_key    = $data[2]->value;
      $secret_access = $data[3]->value;
      $endpoint      = $data[5]->value;

      $this->OssClient = new \OSS\OssClient($access_key, $secret_access, $endpoint);

      $returnPath = '/Uploads';
      $filepath = public_path($returnPath);


      $this->data['oss_real_path'] = $this->dir.date('Y_m_d');
      $this->data['real_path'] = $filepath;

      // 判断是否又自定义路径
      if(isset($this->data['filepath']))
      {
        $this->data['real_path'] = $filepath;
        $this->data['oss_real_path'] = $this->dir.$data['filepath'].date('Y_m_d');
      }
    }
    else
    {
      // 过滤所有的.符号
      $path = str_replace('.', '', $path);

        // 先去除两边空格
      $path = trim($path, '/');

        // 获取文件后缀
      $extension = strtolower($file->getClientOriginalExtension());

        // 组合新的文件名
      $newName = md5(time()).'.'.$extension;

        // 获取上传的文件名
      $oldName = $file->getClientOriginalName();

      if (!empty($allowExtension) && !in_array($extension, $allowExtension))
      {
        return [
          'status' => Code::FILE_UPLOAD_EXTENSION_ERROR,
          'message' => Code::$message[Code::FILE_UPLOAD_EXTENSION_ERROR]
        ];
      }

      $dir = $path . DIRECTORY_SEPARATOR . date('Y-m-d');

      Storage::disk($disk)->makeDirectory($dir);

      $filename = $dir . DIRECTORY_SEPARATOR . $newName;

      if(Storage::disk($disk)->put($filename, file_get_contents($file)))
      {
        return  Storage::url($filename);
      }
      else
      {
        return false;
      }
    }
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-24
   * ------------------------------------------
   * 上传文件（base64）
   * ------------------------------------------
   *
   * 上传文件（base64）
   *
   * @param string $file 数据内容
   * @param string $path 路径
   * @param string $disk 用那种方式上传 oss, cos, qiniu, 又拍云
   * @param array $extension 允许上传的后缀
   * @return [type]
   */
  public static function file_base64($file, $path = 'uploads', $disk = 'public', $allowExtension = [])
  {
    try
    {
      if(false !==strpos($file, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))
      {
        // 替换编码头
        preg_match('/^(data:application\/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,)/', $file, $data);
        $data[2] = 'docx';
      }
      else if(false !==strpos($file, 'application/msword'))
      {
        // 替换编码头
        preg_match('/^(data:application\/msword;base64,)/', $file, $data);
        $data[2] = 'doc';
      }
      else if(false !==strpos($file, 'application/vnd.ms-excel application/x-excel'))
      {
        // 替换编码头
        preg_match('/^(data:application\/vnd.ms-excel application\/x-excel;base64,)/', $file, $data);
        $data[2] = 'xls';
      }
      else if(false !==strpos($file, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
      {
        // 替换编码头
        preg_match('/^(data:application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,)/', $file, $data);
        $data[2] = 'xlsx';
      }
      else if(false !==strpos($file, 'application/pdf'))
      {
        // 替换编码头
        preg_match('/^(data:application\/pdf;base64,)/', $file, $data);
        $data[2] = 'pdf';
      }
      else if(false !==strpos($file, 'application/octet-stream'))
      {
        // 替换编码头
        preg_match('/^(data:application\/octet-stream;base64,)/', $file, $data);
        $data[2] = 'xlsx';
      }
      else
      {
        // 替换编码头
        preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $data);
      }

      $file = base64_decode(str_replace($data[1], '', $file));

      // 过滤所有的.符号
      $path = str_replace('.', '', $path);

        // 先去除两边空格
      $path = trim($path, '/');

        // 获取文件后缀
      $extension = $data[2];

      $filename = time() . mt_rand(1, 9999999);

        // 组合新的文件名
      $newName = md5($filename).'.'.$extension;

      $dir = $path . DIRECTORY_SEPARATOR . date('Y-m-d');

      Storage::disk($disk)->makeDirectory($dir);

      $filename = $dir . DIRECTORY_SEPARATOR . $newName;

      if(Storage::disk($disk)->put($filename, $file))
      {
        return  Storage::url($filename);
      }
      else
      {
        return false;
      }
    }
    catch(\Exception $e)
    {
      return false;
    }
  }
}
