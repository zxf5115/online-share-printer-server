<?php
namespace App\Models\Common\Module\Organization;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-25
 *
 * 机构资源模型类
 */
class Resource extends Base
{
  // 表名
  public $table = "module_organization_resource";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'manager_id',
    'business_license',
    'contract',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 代理商资源与会代理商关联表
   * ------------------------------------------
   *
   * 代理商资源与会代理商关联表
   *
   * @return [关联对象]
   */
  public function organization()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'member_id',
      'id'
    );
  }
}
