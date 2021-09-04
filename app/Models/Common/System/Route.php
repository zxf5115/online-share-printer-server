<?php
namespace App\Models\Common\System;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-22
 *
 * 路由模型类
 */
class Route extends Base
{
  // 表名
  public $table = 'system_route';

  // 可以批量修改的字段
  public $fillable = ['id'];

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  public $appends = [
    'remark'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
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
    try
    {
      $content = $this->content ?: '略';

      return $this->title . ' 【 ' . $content . ' 】 ';
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-22
   * ------------------------------------------
   * 路由与自身关联函数
   * ------------------------------------------
   *
   * 路由与自身关联函数
   *
   * @return [type]
   */
  public function children()
  {
    return $this->hasMany(__CLASS__, 'parent_id')
                ->with('children')
                ->where(['status'=>1]);
  }
}
