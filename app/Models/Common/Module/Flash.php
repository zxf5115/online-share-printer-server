<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Flash\FlashEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-09
 *
 * 快讯模型类
 */
class Flash extends Base
{
  // 表名
  protected $table = "module_flash";

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'category_id',
    'user_id',
    'title',
    'content',
    'create_time',
  ];



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-10
   * ------------------------------------------
   * 是否推荐封装
   * ------------------------------------------
   *
   * 是否推荐封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsRecommendAttribute($value)
  {
    return FlashEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-10
   * ------------------------------------------
   * 审核状态封装
   * ------------------------------------------
   *
   * 审核状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getAuditStatusAttribute($value)
  {
    return FlashEnum::getAuditStatus($value);
  }

  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 快讯与快讯分类关联函数
   * ------------------------------------------
   *
   * 快讯与快讯分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Flash\Category',
      'category_id',
      'id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 快讯与快讯评论关联函数
   * ------------------------------------------
   *
   * 快讯与快讯评论关联函数
   *
   * @return [关联对象]
   */
  public function comment()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Flash\Comment',
      'flash_id',
      'id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-10
   * ------------------------------------------
   * 快讯与用户关联函数
   * ------------------------------------------
   *
   * 快讯与用户关联函数
   *
   * @return [关联对象]
   */
  public function user()
  {
    return $this->belongsTo(
      'App\Models\Common\System\User',
      'user_id',
      'id'
    );
  }
}
