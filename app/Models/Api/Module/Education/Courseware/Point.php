<?php
namespace App\Models\Api\Module\Education\Courseware;

use App\Models\Common\Module\Order\Courseware as OrderCourseware;
use App\Models\Common\Module\Education\Courseware\Point as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-23
 *
 * 课件知识点模型类
 */
class Point extends Common
{
  // 隐藏的属性
  public $hidden = [
    'organization_id',
    'sort',
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  public $appends = [
    'is_pay'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-25
   * ------------------------------------------
   * 是否购买课程封装
   * ------------------------------------------
   *
   * 是否购买课程封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getIsPayAttribute($value)
  {
    $member_id = auth('api')->user()->id ?? 0;

    if(empty($member_id))
    {
      return false;
    }

    $where = [
      'status'        => 1,
      'member_id'     => $member_id,
      'courseware_id' => $this->courseware_id
    ];

    $response = OrderCourseware::getRow($where);

    if(empty($response->id))
    {
      return false;
    }

    return true;
  }



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-23
   * ------------------------------------------
   * 课件知识点与课件关联函数
   * ------------------------------------------
   *
   * 课件知识点与课件关联函数
   *
   * @return [关联对象]
   */
  public function courseware()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Education\Courseware',
      'courseware_id',
      'id'
    );
  }

}
