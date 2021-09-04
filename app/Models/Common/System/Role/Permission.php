<?php
namespace App\Models\Common\System\Role;

use App\Models\Base;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-09-20
 *
 * 系统权限模型类
 */
class Permission extends Base
{
  // 表名
  public $table = 'system_role_permission';

  /**
   * 可以被批量赋值的属性
   */
  public $fillable = ['menu_id'];




  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-03-07
   * ------------------------------------------
   * 反向关联用户
   * ------------------------------------------
   *
   * 反向关联用户
   *
   * @return [type]
   */
  public function role()
  {
    return $this->belongsTo('App\Models\Common\System\Role')->where(['status'=>1]);
  }
}
