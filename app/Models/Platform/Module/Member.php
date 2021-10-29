<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Organization;
use App\Models\Common\Module\Member as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 会员模型类
 */
class Member extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-30
   * ------------------------------------------
   * 获取会员数据
   * ------------------------------------------
   *
   * 获取会员数据
   *
   * @param [type] $where [description]
   * @return [type]
   */
  public static function getMemberData()
  {
    try
    {
      $where = [
        'status' => 1
      ];

      $response = 0;

      $member_total = self::getCount($where);

      $where['role_id'] = 2;

      $manager_total = Organization::getCount($where);

      $response = bcadd($member_total, $manager_total);

      return $response;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取打印机数量
   * ------------------------------------------
   *
   * 获取打印机数量
   *
   * @return [type]
   */
  public static function getCountData()
  {
    $where = [
      'status'  => 1
    ];

    return self::getCount($where);
  }
}
