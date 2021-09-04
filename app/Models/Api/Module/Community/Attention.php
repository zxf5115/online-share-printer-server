<?php
namespace App\Models\Api\Module\Community;

use App\Models\Common\Module\Community\Attention as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-01
 *
 * 社区关注模型类
 */
class Attention extends Common
{

  // 隐藏的属性
  public $hidden = [
    'id',
    'organization_id',
    'community_id',
    'member_id',
    'status',
    'update_time'
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 社区关注与社区关联函数
   * ------------------------------------------
   *
   * 社区关注与社区关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Community\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 社区关注与学员关联函数
   * ------------------------------------------
   *
   * 社区关注与学员关联函数
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
