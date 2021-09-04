<?php
namespace App\Models\Platform\Module\Member;

use App\Models\Common\Module\Member\Certification as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员认证模型类
 */
class Certification extends Common
{



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
      'App\Models\Platform\Module\Member\Certification\Project',
      ['certification_id', 'member_id'],
      ['id', 'member_id']
    );
  }
}
