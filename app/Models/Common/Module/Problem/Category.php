<?php
namespace App\Models\Common\Module\Problem;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-05-29
 *
 * 常见问题分类模型类
 */
class Category extends Base
{
  // 表名
  protected $table = "module_problem_category";

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
   * @dateTime 2021-05-29
   * ------------------------------------------
   * 常见问题分类置与常见问题关联函数
   * ------------------------------------------
   *
   * 常见问题分类置与常见问题关联函数
   *
   * @return [关联对象]
   */
  public function problem()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Problem',
      'category_id',
      'id'
    );
  }
}
