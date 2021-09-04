<?php
namespace App\Models\Api\Module\Education\Courseware\Point;

use App\Models\Common\Module\Education\Courseware\Point\Approval as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 课件知识点模型类
 */
class Approval extends Common
{
  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'point_id',
    'member_id',
    'sort',
    'status',
    'update_time'
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-25
   * ------------------------------------------
   * 课程知识点点赞与课程知识点关联函数
   * ------------------------------------------
   *
   * 课程知识点点赞与课程知识点关联函数
   *
   * @return [关联对象]
   */
  public function point()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Education\Courseware\Point',
      'point_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-25
   * ------------------------------------------
   * 课程知识点点赞与学员关联函数
   * ------------------------------------------
   *
   * 课程知识点点赞与学员关联函数
   *
   * @return [关联对象]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Member',
      'member_id',
      'id'
    );
  }
}
