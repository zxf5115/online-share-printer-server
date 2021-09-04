<?php
namespace App\Models\Api\Module\Member;

use App\Models\Common\Module\Member\Certification as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员认证模型类
 */
class Certification extends Common
{
  use \Awobaz\Compoships\Compoships;

  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'member_id',
    'status',
    'create_time',
    'update_time'
  ];



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
      'App\Models\Api\Module\Member\Certification\Personal',
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
      'App\Models\Api\Module\Member\Certification\Company',
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
      'App\Models\Api\Module\Member\Certification\Project',
      ['certification_id', 'member_id'],
      ['id', 'member_id']
    );
  }
}
