<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Enum\Module\Member\CertificationEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员认证模型类
 */
class Certification extends Base
{
  use \Awobaz\Compoships\Compoships;

  // 表名
  public $table = "module_member_certification";

  // 可以批量修改的字段
  public $fillable = ['id'];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-17
   * ------------------------------------------
   * 认证状态封装
   * ------------------------------------------
   *
   * 认证状态封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getTypeAttribute($value)
  {
    return CertificationEnum::getCertificationType($value);
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-17
   * ------------------------------------------
   * 认证状态封装
   * ------------------------------------------
   *
   * 认证状态封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getCertificationStatusAttribute($value)
  {
    return CertificationEnum::getCertificationStatus($value);
  }


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-17
   * ------------------------------------------
   * 会员认证与个人认证关联函数
   * ------------------------------------------
   *
   * 会员认证与个人认证关联函数
   *
   * @return [关联对象]
   */
  public function personal()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Certification\Personal',
      ['certification_id', 'member_id'],
      ['id', 'member_id']
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-17
   * ------------------------------------------
   * 会员认证与企业认证关联函数
   * ------------------------------------------
   *
   * 会员认证与企业认证关联函数
   *
   * @return [关联对象]
   */
  public function company()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Certification\Company',
      ['certification_id', 'member_id'],
      ['id', 'member_id']
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-17
   * ------------------------------------------
   * 会员认证与项目认证关联函数
   * ------------------------------------------
   *
   * 会员认证与项目认证关联函数
   *
   * @return [关联对象]
   */
  public function project()
  {
    return $this->hasOne(
      'App\Models\Common\Module\Member\Certification\Project',
      ['certification_id', 'member_id'],
      ['id', 'member_id']
    );
  }
}
