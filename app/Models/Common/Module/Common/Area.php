<?php
namespace App\Models\Common\Module\Common;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-09-25
 *
 * 全国区域模型类
 */
class Area extends Base
{
  // 表名
  protected $table = "module_area";

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'lng',
    'lat',
    'level',
    'sort',
    'status',
    'create_time',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-20
   * ------------------------------------------
   * 全国区域本类关联函数
   * ------------------------------------------
   *
   * 全国区域无限分类下，使用本类进行关联查询
   *
   * @return [type]
   */
  public function children()
  {
    return $this->hasMany(__CLASS__, 'parent_id')->with('children')->where(['status'=>1]);
  }
}
