<?php
namespace App\Models\Api\Module;

use App\Enum\Common\TimeEnum;
use App\Models\Common\Module\Flash\Benefit;
use App\Models\Common\Module\Flash as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 快讯模型类
 */
class Flash extends Common
{

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'category_id',
    'user_id',
    'audit_status',
    'status',
    'update_time'
  ];

  // 附加数据
  protected $appends = [
    'description',
    'datetime',
    'is_benefit'
  ];

  /**
   * 转换属性类型
   */
  protected $casts = [
    'create_time' => 'datetime:H:i',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 时间封装
   * ------------------------------------------
   *
   * 时间封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getDescriptionAttribute($value)
  {
    return strip_tags($this->content);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 时间封装
   * ------------------------------------------
   *
   * 时间封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getDateTimeAttribute($value)
  {
    $datetime  = date('m月d日 ', strtotime($this->create_time));

    $week = TimeEnum::formatWeek(strtotime($this->create_time));

    return $datetime.$week;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-11
   * ------------------------------------------
   * 资讯评论数量封装
   * ------------------------------------------
   *
   * 资讯评论数量封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsBenefitAttribute($value)
  {
    $flash_id = $this->id ?? '';

    $member_id = auth('api')->user()->id ?? 0;

    if(empty($member_id))
    {
      return 0;
    }

    $where = [
      'member_id' => $member_id,
      'flash_id'  => $flash_id
    ];

    $response = Benefit::getRow($where);

    if(empty($response->id))
    {
      return 0;
    }

    return $response->feel_status['value'] ?? 0;
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
      'App\Models\Api\Module\Flash\Category',
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
      'App\Models\Api\Module\Flash\Comment',
      'flash_id',
      'id'
    );
  }
}
