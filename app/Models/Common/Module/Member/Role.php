<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Http\Constant\Parameter;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-15
 *
 * 会员角色模型类
 */
class Role extends Base
{
  // 表名
  public $table = "module_member_role";

  // 可以批量修改的字段
  public $fillable = ['title', 'content'];

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 用户与角色关联函数
   * ------------------------------------------
   *
   * 用户与角色关联函数
   *
   * @return [关联对象]
   */
  public function menu()
  {
    return $this->belongsToMany(
      'App\Models\Common\Module\Menu',
      'module_member_role_permission',
      'role_id',
      'menu_id'
    )->wherePivot('status', 1);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-16
   * ------------------------------------------
   * 角色与权限关联函数
   * ------------------------------------------
   *
   * 角色与权限关联函数
   *
   * @return [关联对象]
   */
  public function permission()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Member\Permission',
      'role_id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-16
   * ------------------------------------------
   * 注册关联删除
   * ------------------------------------------
   *
   * 注册关联删除
   *
   * @return [type]
   */
  public static function boot()
  {
    parent::boot();

    static::deleted(function($model) {
      $model->permission()->delete();
    });
  }
}
