<?php
namespace App\Models\Common\System;

use App\Models\Base;
use App\Enum\MenuEnum;
use Illuminate\Support\Facades\Redis;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-05
 *
 * 菜单模型类
 */
class Menu extends Base
{
  // 表名
  public $table = "system_menu";

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 批量添加
  public $fillable = ['id'];


  // 追加到模型数组表单的访问器
  public $appends = [
    'remark'
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-16
   * ------------------------------------------
   * 分类状态封装
   * ------------------------------------------
   *
   * 分类状态封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getCategoryAttribute($value)
  {
    return MenuEnum::getCategoryStatus($value);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-16
   * ------------------------------------------
   * 状态属性类型转换函数
   * ------------------------------------------
   *
   * 状态属性类型转换函数
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getTypeAttribute($value)
  {
    return MenuEnum::getTypeStatus($value);
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-16
   * ------------------------------------------
   * 拼接菜单信息
   * ------------------------------------------
   *
   * 拼接菜单信息, 用于显示菜单权限
   *
   * @return 菜单权限
   */
  public function getRemarkAttribute()
  {
    $content = $this->content ?: '略';
    $type = !empty($this->type) ? $this->type['text'] : '菜单';
    return $this->title . ' ['. $type . ']' . ' 【 ' . $content . ' 】 ';
  }




  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 权限与菜单关联函数
   * ------------------------------------------
   *
   * 权限与菜单关联函数
   *
   * @return [关联对象]
   */
  public function permission()
  {
    return $this->hasOne('App\Models\Common\System\Role', 'role_id')->where(['status'=>1]);
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-22
   * ------------------------------------------
   * 菜单本类关联函数
   * ------------------------------------------
   *
   * 菜单无限分类下，使用本类进行关联查询
   *
   * @return [type]
   */
  public function children()
  {
    return $this->hasMany(__CLASS__, 'parent_id')
                ->with('children')
                ->where(['status'=>1]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-22
   * ------------------------------------------
   * 导航本类关联函数
   * ------------------------------------------
   *
   * 导航无限分类下，使用本类进行关联查询
   *
   * @return [type]
   */
  public function navigation()
  {
    return $this->hasMany(__CLASS__, 'parent_id')
                ->with('navigation')
                ->where(['status'=>1])
                ->whereIn('type', [1, 3]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-22
   * ------------------------------------------
   * 按钮本类关联函数
   * ------------------------------------------
   *
   * 按钮无限分类下，使用本类进行关联查询
   *
   * @return [type]
   */
  public function button()
  {
    return $this->hasMany(__CLASS__, 'parent_id')
                ->with('button')
                ->where(['status'=>1])
                ->whereIn('type', [1, 2]);
  }
}
