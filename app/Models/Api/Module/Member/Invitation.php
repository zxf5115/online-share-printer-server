<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Invitation as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-16
 *
 * 学员邀请模型类
 */
class Invitation extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-16
   * ------------------------------------------
   * 学员与学员关联表
   * ------------------------------------------
   *
   * 学员与学员关联表
   *
   * @return [关联对象]
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
   * @dateTime 2021-01-16
   * ------------------------------------------
   * 学员与邀请学员关联表
   * ------------------------------------------
   *
   * 学员与邀请学员关联表
   *
   * @return [关联对象]
   */
  public function invitation()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Member',
      'invitation_member_id',
      'id'
    );
  }
}
