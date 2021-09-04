<?php
namespace App\Models\Common\Module\Information;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-09
 *
 * 资讯分类模型类
 */
class Category extends Base
{
  // 表名
  protected $table = "module_information_category";

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
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯分类置与资讯关联函数
   * ------------------------------------------
   *
   * 资讯分类置与资讯关联函数
   *
   * @return [关联对象]
   */
  public function information()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Information',
      'information_id',
      'id'
    );
  }
}
