<?php
namespace App\Models\Common\System;

use App\Models\Base;
use App\TraitClass\UserTrait;
use App\Http\Constant\Parameter;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-14
 *
 * 用户模型类
 */
class User extends Base
{
  use UserTrait;

  // 表名
  public $table = "system_user";

  // 可以批量修改的字段
  public $fillable = [
    'organization_id',
    'username',
    'password',
  ];

  // 隐藏的属性
  public $hidden = [
    'password',
    'remember_token',
    'password_salt',
    'try_number',
    'last_login_ip'
  ];



  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 关联到角色表
   * ------------------------------------------
   *
   * 关联到角色表
   *
   * @return [关联对象]
   */
  public function role()
  {
    return $this->belongsTo(
      'App\Models\Common\System\Role',
      'role_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 用户与消息关联函数
   * ------------------------------------------
   *
   * 用户与消息关联函数
   *
   * @return [关联对象]
   */
  public function message()
  {
    return $this->hasMany(
      'App\Models\Common\System\User\UserMessage',
      'user_id',
      'id'
    );
  }
}
