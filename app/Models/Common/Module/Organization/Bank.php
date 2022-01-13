<?php
namespace App\Models\Common\Module\Organization;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-01-13
 *
 * 机构银行模型类
 */
class Bank extends Base
{
  // 表名
  public $table = "module_organization_bank";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
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
   * @dateTime 2021-12-06
   * ------------------------------------------
   * 机构银行与机构关联表
   * ------------------------------------------
   *
   * 机构银行与机构关联表
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
