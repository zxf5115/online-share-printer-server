<?php
namespace App\Models\Common\System\Config;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-16
 *
 * 配置分类模型类
 */
class ConfigCategory extends Base
{
  // 表名
  public $table = "system_config_category";

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  public $appends = [];

  // 批量添加
  public $fillable = ['id'];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 系统配置分类与系统配置关联函数
   * ------------------------------------------
   *
   * 系统配置分类与系统配置关联函数
   *
   * @return [关联对象]
   */
  public function config()
  {
    return $this->hasMany(
      'App\Models\Common\System\Config',
      'category_id',
      'id'
    )->where(['status'=>1]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 系统配置分类本类关联函数
   * ------------------------------------------
   *
   * 系统配置分类无限分类下，使用本类进行关联查询
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
