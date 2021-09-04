<?php
namespace App\Models\Api\Module;

use App\Models\Common\Module\Notice as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-21
 *
 * 通知模型类
 */
class Notice extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'category_id',
    'status',
    'create_time',
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-22
   * ------------------------------------------
   * 通知与会员通知关联函数
   * ------------------------------------------
   *
   * 通知与会员通知关联函数
   *
   * @return [type]
   */
  public function relevance()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Member\MemberNotice',
      'notice_id',
      'id'
    );
  }
}
