<?php
namespace App\Models\Common\Module;

use App\Models\Base;
use App\Enum\Module\Information\InformationEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-09
 *
 * 资讯模型类
 */
class Information extends Base
{
  // 表名
  protected $table = "module_information";

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-14
   * ------------------------------------------
   * 是否专题状态封装
   * ------------------------------------------
   *
   * 是否专题状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsSubjectAttribute($value)
  {
    return InformationEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-11
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
    return InformationEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-11
   * ------------------------------------------
   * 是否置顶状态封装
   * ------------------------------------------
   *
   * 是否置顶状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsTopAttribute($value)
  {
    return InformationEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-11
   * ------------------------------------------
   * 是否评论状态封装
   * ------------------------------------------
   *
   * 是否评论状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsCommentAttribute($value)
  {
    return InformationEnum::getStatus($value);
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
    return InformationEnum::getAuditStatus($value);
  }


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯与资讯分类关联函数
   * ------------------------------------------
   *
   * 资讯与资讯分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Information\Category',
      'category_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-14
   * ------------------------------------------
   * 资讯与资讯专题关联函数
   * ------------------------------------------
   *
   * 资讯与资讯专题关联函数
   *
   * @return [关联对象]
   */
  public function subject()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Information\Subject',
      'subject_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯与标签关联函数
   * ------------------------------------------
   *
   * 资讯与标签关联函数
   *
   * @return [关联对象]
   */
  public function label()
  {
    return $this->belongsToMany(
      'App\Models\Common\Module\Label',
      'module_information_label',
      'information_id',
      'label_id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯与资讯标签关联函数
   * ------------------------------------------
   *
   * 资讯与资讯标签关联函数
   *
   * @return [关联对象]
   */
  public function labelRelevance()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Information\Label',
      'information_id',
      'id',
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-12
   * ------------------------------------------
   * 资讯与关联资讯关联函数
   * ------------------------------------------
   *
   * 资讯与关联资讯关联函数
   *
   * @return [关联对象]
   */
  public function similar()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Information\Similar',
      'information_id',
      'id',
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯与资讯评论关联函数
   * ------------------------------------------
   *
   * 资讯与资讯评论关联函数
   *
   * @return [关联对象]
   */
  public function comment()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Information\Comment',
      'information_id',
      'id'
    );
  }
}
