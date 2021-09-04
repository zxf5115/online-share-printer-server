<?php
namespace App\Models\Common\Module\Education;

use App\Models\Base;
use App\Enum\Module\Education\CoursewareEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-05
 *
 * 课件模型类
 */
class Courseware extends Base
{
  // 表名
  public $table = "module_courseware";

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];

  // 批量添加
  public $fillable = ['id'];


  // 追加到模型数组表单的访问器
  public $appends = [
    'point_total'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-25
   * ------------------------------------------
   * 课程知识点数量封装
   * ------------------------------------------
   *
   * 课程知识点数量封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getPointTotalAttribute($value)
  {
    $response = 0;

    if(!empty($this->point))
    {
      $response = count($this->point);

      unset($this->point);
    }

    return $response;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 是否上架课程封装
   * ------------------------------------------
   *
   * 是否上架课程封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsShelfAttribute($value)
  {
    return CoursewareEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 是否试看课程封装
   * ------------------------------------------
   *
   * 是否试看课程封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsTrialAttribute($value)
  {
    return CoursewareEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 是否推荐课程封装
   * ------------------------------------------
   *
   * 是否推荐课程封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsRecommendAttribute($value)
  {
    return CoursewareEnum::getStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 课件与课件分类关联函数
   * ------------------------------------------
   *
   * 课件与课件分类关联函数
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Education\Courseware\Category',
      'category_id',
      'id'
    );
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 课件与课件老师关联函数
   * ------------------------------------------
   *
   * 课件与课件老师关联函数
   *
   * @return [关联对象]
   */
  public function teacher()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Education\Courseware\Teacher',
      'teacher_id',
      'id'
    );
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-25
   * ------------------------------------------
   * 课件与课件知识点关联函数
   * ------------------------------------------
   *
   * 课件与课件知识点关联函数
   *
   * @return [关联对象]
   */
  public function point()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Education\Courseware\Point',
      'courseware_id',
      'id'
    )->where(['status'=>1]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-08
   * ------------------------------------------
   * 课件与会员课件知识点关联函数
   * ------------------------------------------
   *
   * 课件与会员课件知识点关联函数
   *
   * @return [关联对象]
   */
  public function memberPoint()
  {
    // return $this->hasMany(
    //   'App\Models\Common\Module\Member\Relevance\Relevance\Relevance\Point',
    //   'courseware_id',
    //   'id'
    // );
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-16
   * ------------------------------------------
   * 注册关联删除
   * ------------------------------------------
   *
   * 注册关联删除
   *
   * @return [type]
   */
  public static function boot()
  {
    parent::boot();

    static::updated(function($model) {
      // $model->memberPoint()->update(['status' => -1]);
    });
  }
}
