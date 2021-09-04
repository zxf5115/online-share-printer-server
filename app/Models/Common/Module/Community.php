<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Community\CommunityEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-21
 *
 * 社区模型类
 */
class Community extends Base
{
  // 表名
  protected $table = "module_community";

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-12
   * ------------------------------------------
   * 是否热门状态封装
   * ------------------------------------------
   *
   * 是否热门状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsHotAttribute($value)
  {
    return CommunityEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-12
   * ------------------------------------------
   * 是否推荐状态封装
   * ------------------------------------------
   *
   * 是否推荐状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsRecommendAttribute($value)
  {
    return CommunityEnum::getStatus($value);
  }


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 社区与社区分类关联函数
   * ------------------------------------------
   *
   * 社区与社区分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Community\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 社区与社区评论关联函数
   * ------------------------------------------
   *
   * 社区与社区评论关联函数
   *
   * @return [关联对象]
   */
  public function comment()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Community\Comment',
      'community_id',
      'id'
    );
  }
}
