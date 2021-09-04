<?php
namespace App\Models\Api\Module\Member\Role;

use App\Models\Common\Module\Member\Role\Permission as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-20
 *
 * 会员权限模型类
 */
class Permission extends Common
{
  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];// 关联函数 ------------------------------------------------------


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
      'App\Models\Api\Module\Member\Role',
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
      'App\Models\Api\System\Route',
      'route_id',
      'id'
    );
  }
}
