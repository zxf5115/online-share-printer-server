<?php
namespace App\Models\Common\Module\Repair;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 报修分类模型类
 */
class Category extends Base
{
  // 表名
  protected $table = "module_repair_category";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 报修分类与报修关联函数
   * ------------------------------------------
   *
   * 报修分类与报修关联函数
   *
   * @return [关联对象]
   */
  public function repair()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Repair',
      'category_id',
      'id'
    );
  }
}
