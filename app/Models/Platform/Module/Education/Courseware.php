<?php
namespace App\Models\Platform\Module\Education;

use App\Models\Common\Module\Education\Courseware as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-23
 *
 * 课件模型类
 */
class Courseware extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取课程数据
   * ------------------------------------------
   *
   * 获取课程数据
   *
   * @param string $is_shelf [description]
   * @return [type]
   */
  public static function getCoursewareData($is_shelf = '')
  {
    try
    {
      $response = 0;

      $where = ['status' => 1];

      if($is_shelf)
      {
        $where = array_merge($where, ['is_shelf' => $is_shelf]);
      }

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
