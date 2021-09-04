<?php
namespace App\Models\Common\Module;

use App\Models\Base;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-20
 *
 * 通知模型类
 */
class Notice extends Base
{
  // 表名
  public $table = 'module_notice';

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'title',
    'content'
  ];

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-13
   * ------------------------------------------
   * 通知与通知分类关联函数
   * ------------------------------------------
   *
   * 通知与通知分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Notice\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-22
   * ------------------------------------------
   * 消息与会员消息关联函数
   * ------------------------------------------
   *
   * 消息与会员消息关联函数
   *
   * @return [type]
   */
  public function relevance()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Member\MemberNotice',
      'notice_id',
      'id'
    );
  }
}
