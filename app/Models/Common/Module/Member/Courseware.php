<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Enum\Module\Education\CoursewareEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 会员课程关联模型类
 */
class Courseware extends Base
{
  // 表名
  public $table = 'module_member_courseware';

  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'status',
    'create_time',
    'update_time'
  ];

  /**
   * 可以被批量赋值的属性
   */
  public $fillable = [
    'organization_id',
    'member_id',
    'courseware_id',
  ];

  // 追加到模型数组表单的访问器
  public $appends = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 是否学习完成课程封装
   * ------------------------------------------
   *
   * 是否学习完成课程封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getIsFinishAttribute($value)
  {
    return CoursewareEnum::getFinishStatus($value);
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 课程来源封装
   * ------------------------------------------
   *
   * 课程来源封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getSourceAttribute($value)
  {
    return CoursewareEnum::getSourceStatus($value);
  }


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 会员课程与会员关联函数
   * ------------------------------------------
   *
   * 会员课程与会员关联函数
   *
   * @return [type]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Member',
      'member_id',
      'id'
    )->where(['status'=>1]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 会员课程与课件关联函数
   * ------------------------------------------
   *
   * 会员课程与课件关联函数
   *
   * @return [type]
   */
  public function courseware()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Education\Courseware',
      'courseware_id',
      'id'
    )->where(['status'=>1]);
  }
}
