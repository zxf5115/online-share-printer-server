<?php
namespace App\Models\Common\Module\Organization;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-19
 *
 * 学员资产模型类
 */
class Asset extends Base
{
  // 表名
  public $table = "module_organization_asset";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
    'red_envelope',
    'lollipop',
    'production',
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
   * 机构资产与机构分红关联表
   * ------------------------------------------
   *
   * 机构资产与机构分红关联表
   *
   * @return [关联对象]
   */
  public function obtain()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Organization\Obtain',
      'member_id',
      'id'
    );
  }
}
