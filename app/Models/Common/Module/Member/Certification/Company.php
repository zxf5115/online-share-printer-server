<?php
namespace App\Models\Common\Module\Member\Certification;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员企业认证模型类
 */
class Company extends Base
{
  use \Awobaz\Compoships\Compoships;

  // 表名
  public $table = "module_member_certification_company";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'company_name',
    'business_license_no',
    'business_license_picture',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

}
