<?php
namespace App\Models\Common\Module\Community;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 社区点赞模型类
 */
class Approval extends Base
{
  // 表名
  protected $table = "module_community_approval";

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
    'community_id',
    'member_id',
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
   * ------------------------------------------
   * 社区点赞与社区关联函数
   * ------------------------------------------
   *
   * 社区点赞与社区关联函数
   *
   * @return [关联对象]
   */
  public function community()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Community',
      'community_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
   * ------------------------------------------
   * 社区点赞与学员关联函数
   * ------------------------------------------
   *
   * 社区点赞与学员关联函数
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
