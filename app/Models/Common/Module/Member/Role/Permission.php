<?php
namespace App\Models\Common\Module\Member\Role;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-20
 *
 * 会员权限模型类
 */
class Permission extends Base
{
  // 表名
  public $table = 'module_member_role_permission';

  /**
   * 可以被批量赋值的属性
   */
  public $fillable = [
    'id',
    'organization_id',
    'route_id'
  ];

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 会员权限与会员角色关联函数
   * ------------------------------------------
   *
   * 会员权限与会员角色关联函数
   *
   * @return [type]
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
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 会员权限与会员角色关联函数
   * ------------------------------------------
   *
   * 会员权限与会员角色关联函数
   *
   * @return [type]
   */
  public function route()
  {
    return $this->belongsTo(
      'App\Models\Common\System\Route',
      'route_id',
      'id'
    );
  }
}
