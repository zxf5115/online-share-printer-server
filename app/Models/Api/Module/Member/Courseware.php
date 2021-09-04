<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Courseware as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 会员课程模型类
 */
class Courseware extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'member_id',
    'source',
    'status',
    'update_time'
  ];

  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 会员课程与会员关联函数
   * ------------------------------------------
   *
   * 会员课程与会员关联函数
   *
   * @return [type]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Member',
      'member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 会员课程与课件关联函数
   * ------------------------------------------
   *
   * 会员课程与课件关联函数
   *
   * @return [type]
   */
  public function courseware()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Education\Courseware',
      'courseware_id',
      'id'
    );
  }
}
