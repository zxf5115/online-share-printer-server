<?php
namespace App\Models\Api\Module\Information;

use App\Models\Api\Module\Information\Comment\Approval;
use App\Models\Common\Module\Information\Comment as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯评论模型类
 */
class Comment extends Common
{
  use \Awobaz\Compoships\Compoships;

  // 隐藏的属性
  protected $hidden = [
    'organization_id',
    'member_id',
    'status',
    'update_time'
  ];


  // 追加到模型数组表单的访问器
  protected $appends = [
    'is_approval',
    'approval_total'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-31
   * ------------------------------------------
   * 获取子集数据
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param [type] $data [description]
   * @return [type]
   */
  public static function getChildData($data)
  {
    try
    {
      $response = 0;

      if(empty($data))
      {
        $data;
      }

      foreach($data as $key => $item)
      {
        $where = [
          'comment_id' => $item['id']
        ];

        $order = [['key' => 'create_time', 'value' => 'desc']];

        $response = self::getList($where, 'member', $order, true);

        if(empty($response))
        {
          continue;
        }

        $total = count($response);

        $data[$key]['other_total'] = ($total > 3) ? ($total - 3) : 0;

        $data[$key]['children'] = array_splice($response, 0, 3);
      }

      return $data;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-11
   * ------------------------------------------
   * 是否点赞封装
   * ------------------------------------------
   *
   * 是否点赞封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getIsApprovalAttribute($value)
  {
    $comment_id = $this->id ?? '';

    $member_id = auth('api')->user()->id ?? 0;

    if(empty($member_id))
    {
      return false;
    }

    $where = [
      'member_id'  => $member_id,
      'comment_id' => $comment_id
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
   * @dateTime 2021-07-01
   * ------------------------------------------
   * 点赞数量封装
   * ------------------------------------------
   *
   * 点赞数量封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getApprovalTotalAttribute($value)
  {
    $comment_id = $this->id;

    $response = Approval::getCount(['comment_id' => $comment_id]);

    return $response;
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯评论置与资讯关联函数
   * ------------------------------------------
   *
   * 资讯评论置与资讯关联函数
   *
   * @return [关联对象]
   */
  public function information()
  {
    return $this->hasMany(
      'App\Models\Api\Module\Information',
      'information_id',
      'id'
    );
  }




  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 无限评论封装
   * ------------------------------------------
   *
   * 无限评论封装
   *
   * @return [type]
   */
  public function children()
  {
    return $this->hasMany(__CLASS__, ['information_id', 'comment_id'], ['information_id', 'id'])
                ->where([['comment_id', '<>', 0], 'status'=>1])
                ->orderBy('create_time', 'desc');
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-03
   * ------------------------------------------
   * 评论与被评论人关联表
   * ------------------------------------------
   *
   * 评论与被评论人关联表
   *
   * @return [关联对象]
   */
  public function bemember()
  {
    return $this->belongsTo(
      'App\Models\Api\Module\Member',
      'be_member_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-11
   * ------------------------------------------
   * 评论与评论人关联表
   * ------------------------------------------
   *
   * 评论与评论人关联表
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
