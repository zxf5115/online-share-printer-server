<?php
namespace App\Models\Common\Module;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 耗材模型类
 */
class Material extends Base
{
  // 表名
  protected $table = "module_material";

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
   * 耗材与耗材分类关联函数
   * ------------------------------------------
   *
   * 耗材与耗材分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Material\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
   * ------------------------------------------
   * 打印机与所属者关联函数
   * ------------------------------------------
   *
   * 打印机与所属者关联函数
   *
   * @return [关联对象]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Member',
      'member_id',
      'id'
    );
  }
}
