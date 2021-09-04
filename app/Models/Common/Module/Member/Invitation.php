<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-16
 *
 * 学员邀请模型类
 */
class Invitation extends Base
{
  // 表名
  public $table = "module_member_invitation";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
    'invitation_member_id',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
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
      'App\Models\Common\Module\Member',
      'member_id',
      'id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
   * ------------------------------------------
   * 学员与邀请学员关联表
   * ------------------------------------------
   *
   * 学员与邀请学员关联表
   *
   * @return [关联对象]
   */
  public function invitationMember()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Member',
      'invitation_member_id',
      'id'
    );
  }
}
