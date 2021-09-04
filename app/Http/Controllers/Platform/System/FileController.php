<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;

use zxf5115\Upload\File;
use App\Http\Constant\Common\System\FileCode;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-16
 *
 * 文件上传控制器类
 */
class FileController extends BaseController
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 上传文件
   * ------------------------------------------
   *
   * 上传文件
   *
   * @param {object} $file 文件数据
   * @param {string} $category 文件分类 excel word pdf ...
   *
   * @return [type]
   */
  public function file(Request $request)
  {
    try
    {
      $category = $request->category ?? 'file';

      $response = File::file('file', $category);

      // 如果返回错误代码
      if(false === strpos($response, 'http'))
      {
        return self::message($response);
      }

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(FileCode::FILE_UPLOAD_ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-18
   * ------------------------------------------
   * 上传图片
   * ------------------------------------------
   *
   * 上传图片
   *
   * @param {object} $file 图片数据
   * @param {string} $category 图片分类 picture advertising avatar ...
   *
   * @return [type]
   */
  public function picture(Request $request)
  {
    try
    {
      $category = $request->category ?? 'picture';

      $response = File::picture('file', $category);

      // 如果返回错误代码
      if(false === strpos($response, 'http'))
      {
        return self::message($response);
      }

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(FileCode::FILE_UPLOAD_ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 上传文件(编辑器)
   * ------------------------------------------
   *
   * 上传文件(编辑器)
   *
   * @param {object} $file 文件数据
   *
   * @return [type]
   */
  public function editor_file(Request $request)
  {
    try
    {
      $response = File::file('file', 'file');

      $link = ["link" => $response];

      // 如果返回错误代码
      if(false === strpos($response, 'http'))
      {
        return json_encode($link);
      }

      return json_encode($link);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(FileCode::FILE_UPLOAD_ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-18
   * ------------------------------------------
   * 上传图片(编辑器)
   * ------------------------------------------
   *
   * 上传图片(编辑器)
   *
   * @param {object} $file 图片数据
   * @param {string} $category 图片分类 picture advertising avatar ...
   *
   * @return [type]
   */
  public function editor_picture(Request $request)
  {
    try
    {
      $response = File::picture('file', 'picture');

      $link = ["link" => $response];

      // 如果返回错误代码
      if(false === strpos($response, 'http'))
      {
        return json_encode($link);
      }

      return json_encode($link);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(FileCode::FILE_UPLOAD_ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-03
   * ------------------------------------------
   * 上传附件
   * ------------------------------------------
   *
   * 上传附件
   *
   * @param {object} $file 文件数据
   * @param {string} $category 文件分类 excel word pdf ...
   *
   * @return [type]
   */
  public function attachment(Request $request)
  {
    try
    {
      $category = $request->category ?? 'file';

      $response = File::file('file', $category, false, true);

      // 如果返回错误代码
      if(is_string($response) && false === strpos($response, 'http'))
      {
        return self::message($response);
      }

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(FileCode::FILE_UPLOAD_ERROR);
    }
  }
}
