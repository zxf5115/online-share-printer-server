<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Organization as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 机构模型类
 */
class Organization extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取机构数据
   * ------------------------------------------
   *
   * 获取机构数据
   *
   * @param [type] $where [description]
   * @return [type]
   */
  public static function getMemberData($where)
  {
    try
    {
      $response = 0;

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
