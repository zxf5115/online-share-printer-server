<?php
namespace App\Models\Api\Module;

use App\Enum\Common\TimeEnum;
use App\Models\Common\Module\Community\Approval;
use App\Models\Common\Module\Community\Attention;
use App\Models\Common\Module\Community as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-21
 *
 * 社区模型类
 */
class Community extends Common
{
  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'status',
    'update_time'
  ];


  // 追加到模型数组表单的访问器
  protected $appends = [
    'comment_total',
    'collection_total',
    'is_approval',
    'is_attention'
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
  public function getCommentTotalAttribute($value)
  {
    $comment = $this->comment ?? '';

    unset($this->comment);

    if(empty($comment))
    {
      return 0;
    }

    return count($comment);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-11
   * ------------------------------------------
   * 资讯收藏数量封装
   * ------------------------------------------
   *
   * 资讯收藏数量封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getCollectionTotalAttribute($value)
  {
    $collection = $this->collection ?? '';

    unset($this->collection);

    if(empty($collection))
    {
      return 0;
    }

    return count($collection);
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
  public function getIsApprovalAttribute($value)
  {
    $community_id = $this->id ?? '';

    $member_id = auth('api')->user()->id ?? 0;

    if(empty($member_id))
    {
      return false;
    }

    $where = [
      'member_id'    => $member_id,
      'community_id' => $community_id
    ];

    $approval = Approval::getRow($where);

    if(empty($approval->id))
    {
      return false;
    }

    return true;
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
  public function getIsAttentionAttribute($value)
  {
    $community_id = $this->id ?? '';

    $community = self::getRow(['id' => $community_id]);

    if(empty($community))
    {
      return false;
    }

    $category_id = $community->category_id;

    $member_id = auth('api')->user()->id ?? 0;

    if(empty($member_id))
    {
      return false;
    }

    $where = [
      'member_id'   => $member_id,
      'category_id' => $category_id
    ];

    $approval = Attention::getRow($where);

    if(empty($approval->id))
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
      'App\Models\Api\Module\Community\Category',
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
      'App\Models\Api\Module\Community\Comment',
      'community_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 社区与社区收藏关联函数
   * ------------------------------------------
   *
   * 社区与社区收藏关联函数
   *
   * @return [关联对象]
   */
  public function collection()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Community\Collection',
      'community_id',
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
