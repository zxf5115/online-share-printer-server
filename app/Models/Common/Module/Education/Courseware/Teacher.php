<?php
namespace App\Models\Common\Module\Education\Courseware;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-24
 *
 * 课件老师模型类
 */
class Teacher extends Base
{
  // 表名
  protected $table = "module_courseware_teacher";

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
   * @dateTime 2021-06-24
   * ------------------------------------------
   * 课件老师与课件关联函数
   * ------------------------------------------
   *
   * 课件老师与课件关联函数
   *
   * @return [关联对象]
   */
  public function courseware()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Education\Courseware',
      'courseware_id',
      'id'
    );
  }
}
