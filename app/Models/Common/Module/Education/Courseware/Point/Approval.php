<?php
namespace App\Models\Common\Module\Education\Courseware\Point;

use App\Models\Base;
use App\Http\Constant\Status;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 课程知识点点赞模型类
 */
class Approval extends Base
{
  // 表名
  protected $table = "module_courseware_point_approval";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'organization_id',
    'point_id',
    'member_id',
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
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
      'App\Models\Common\Module\Education\Courseware\Point',
      'point_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
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
      'App\Models\Common\Module\Member',
      'member_id',
      'id'
    );
  }
}
