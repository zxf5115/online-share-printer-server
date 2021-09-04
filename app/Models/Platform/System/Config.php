<?php
namespace App\Models\Platform\System;

use App\Models\Common\System\Config as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-08
 *
 * 配置模型类
 */
class Config extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-22
   * ------------------------------------------
   * 改变配置值
   * ------------------------------------------
   *
   * 改变配置值
   *
   * @param [type] $data [description]
   * @return [type]
   */
  public static function change($data)
  {
    try
    {
      $model = new self();

      if(empty($data) || !is_array($data))
      {
        return false;
      }

      foreach($data as $key => $value)
      {
        $response = $model->where(['title' => $key])->update(['value' => $value]);
      }

      return true;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return false;
    }
  }

}
