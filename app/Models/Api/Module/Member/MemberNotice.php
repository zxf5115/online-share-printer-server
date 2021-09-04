<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\MemberNotice as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-20
 *
 * 会员通知模型类
 */
class MemberNotice extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'member_id',
    'message_id',
    'status',
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 会员通知与会员关联函数
   * ------------------------------------------
   *
   * 会员通知与会员关联函数
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
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 会员通知与通知关联函数
   * ------------------------------------------
   *
   * 会员通知与通知关联函数
   *
   * @return [type]
   */
  public function notice()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Notice',
      'notice_id',
      'id'
    );
  }
}
