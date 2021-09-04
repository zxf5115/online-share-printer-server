<?php
namespace App\Models\Api\Module;

use App\Enum\Common\TimeEnum;
use App\Models\Api\Module\Member\Attention;
use App\Models\Api\Module\Information\Approval;
use App\Models\Api\Module\Information\Collection;
use App\Models\Common\Module\Information as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯模型类
 */
class Information extends Common
{

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'audit_status',
    'status',
    'update_time'
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
  public function getCreateTimeAttribute($value)
  {
    return TimeEnum::formatDateTime($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-30
   * ------------------------------------------
   * 是否关注作者
   * ------------------------------------------
   *
   * 是否关注作者
   *
   * @param [type] $member_id 当前用户编号
   * @param [type] $id 资讯编号
   * @return [type]
   */
  public static function getIsAttention($member_id, $id)
  {
    if(empty($member_id))
    {
      return false;
    }

    $information = self::getRow(['id' => $id]);

    if(empty($information->id))
    {
      return false;
    }

    $attention_member_id = $information->member_id;

    $where = [
      'member_id'           => $member_id,
      'attention_member_id' => $attention_member_id
    ];

    $result = Attention::getRow($where);

    if(empty($result->id))
    {
      return false;
    }

    return true;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-30
   * ------------------------------------------
   * 是否点赞资讯
   * ------------------------------------------
   *
   * 是否点赞资讯
   *
   * @param [type] $member_id 当前用户编号
   * @param [type] $id 资讯编号
   * @return [type]
   */
  public static function getIsApproval($member_id, $id)
  {
    if(empty($member_id))
    {
      return false;
    }

    $where = [
      'member_id' => $member_id,
      'information_id' => $id
    ];

    $result = Approval::getRow($where);

    if(empty($result->id))
    {
      return false;
    }

    return true;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-30
   * ------------------------------------------
   * 是否点赞收藏
   * ------------------------------------------
   *
   * 是否点赞收藏
   *
   * @param [type] $member_id 当前用户编号
   * @param [type] $id 资讯编号
   * @return [type]
   */
  public static function getIsCollection($member_id, $id)
  {
    if(empty($member_id))
    {
      return false;
    }

    $where = [
      'member_id' => $member_id,
      'information_id' => $id
    ];

    $result = Collection::getRow($where);

    if(empty($result->id))
    {
      return false;
    }

    return true;
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
      'App\Models\Api\Module\Information\Category',
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
      'App\Models\Api\Module\Information\Subject',
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
      'App\Models\Api\Module\Label',
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
      'App\Models\Api\Module\Information\Label',
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
      'App\Models\Api\Module\Information\Comment',
      'information_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-11
   * ------------------------------------------
   * 资讯与会员关联函数
   * ------------------------------------------
   *
   * 资讯与会员关联函数
   *
   * @return [type]
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
