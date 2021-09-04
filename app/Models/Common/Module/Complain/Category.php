<?php
namespace App\Models\Common\Module\Complain;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-05
 *
 * 投诉分类模型类
 */
class Category extends Base
{
  // 表名
  protected $table = "module_complain_category";

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
   * @dateTime 2020-12-28
   * ------------------------------------------
   * 投诉分类置与广告关联函数
   * ------------------------------------------
   *
   * 投诉分类置与广告关联函数
   *
   * @return [关联对象]
   */
  public function complain()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Complain',
      'category_id',
      'id'
    );
  }
}
