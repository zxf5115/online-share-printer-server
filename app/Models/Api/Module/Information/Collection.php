<?php
namespace App\Models\Api\Module\Information;

use App\Models\Common\Module\Information\Collection as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯收藏模型类
 */
class Collection extends Common
{

  // 隐藏的属性
  protected $hidden = [
    'id',
    'organization_id',
    'information_id',
    'member_id',
    'status',
    'create_time',
    'update_time'
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-11
   * ------------------------------------------
   * 资讯点赞与资讯关联函数
   * ------------------------------------------
   *
   * 资讯点赞与资讯关联函数
   *
   * @return [关联对象]
   */
  public function information()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Information',
      'information_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-11
   * ------------------------------------------
   * 资讯点赞与学员关联函数
   * ------------------------------------------
   *
   * 资讯点赞与学员关联函数
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
