<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\TraitClass\UserTrait;
use App\Enum\Module\Member\MemberEnum;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-08-01
 *
 * 学员模型类
 */
class Member extends Base
{
  use UserTrait;

  // 表名
  public $table = "module_member";

  // 可以批量修改的字段
  public $fillable = [
    'open_id',
    'apply_id',
    'username',
  ];

  // 隐藏的属性
  public $hidden = [
    'password',
    'remember_token',
    'password_salt',
    'try_number',
    'last_login_ip'
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-20
   * ------------------------------------------
   * 学员状态封装
   * ------------------------------------------
   *
   * 学员状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getStatusAttribute($value)
  {
    return MemberEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-20
   * ------------------------------------------
   * 学员审核状态封装
   * ------------------------------------------
   *
   * 学员审核状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getAuditStatusAttribute($value)
  {
    return MemberEnum::getAuditStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-20
   * ------------------------------------------
   * 学员冻结状态封装
   * ------------------------------------------
   *
   * 学员冻结状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsFreezeAttribute($value)
  {
    return MemberEnum::getFreezeStatus($value);
  }


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 学员与机构关联表
   * ------------------------------------------
   *
   * 学员与机构关联表
   *
   * @return [关联对象]
   */
  public function organization()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'organization_id',
      'id'
    );
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 会员与角色关联函数
   * ------------------------------------------
   *
   * 会员与角色关联函数
   *
   * @return [关联对象]
   */
  public function role()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Member\Role',
      'role_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 会员与档案关联函数
   * ------------------------------------------
   *
   * 会员与档案关联函数
   *
   * @return [关联对象]
   */
  public function archive()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Archive',
      'member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 会员与资产关联表
   * ------------------------------------------
   *
   * 会员与资产关联表
   *
   * @return [关联对象]
   */
  public function asset()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Asset',
      'member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-16
   * ------------------------------------------
   * 会员与设置关联表
   * ------------------------------------------
   *
   * 会员与设置关联表
   *
   * @return [关联对象]
   */
  public function setting()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Setting',
      'member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-18
   * ------------------------------------------
   * 会员与会员贵宾关联函数
   * ------------------------------------------
   *
   * 会员与会员贵宾关联函数
   *
   * @return [关联对象]
   */
  public function vip()
  {
    return $this->belongsToMany(
      'App\Models\Common\Module\Vip',
      'module_member_vip',
      'member_id',
      'vip_id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 会员与会员贵宾关联函数
   * ------------------------------------------
   *
   * 会员与会员贵宾关联函数
   *
   * @return [type]
   */
  public function vipRelevance()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Vip',
      'member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-18
   * ------------------------------------------
   * 会员与会员认证关联函数
   * ------------------------------------------
   *
   * 会员与会员认证关联函数
   *
   * @return [关联对象]
   */
  public function certification()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Certification',
      'member_id',
      'id'
    );
  }
}
