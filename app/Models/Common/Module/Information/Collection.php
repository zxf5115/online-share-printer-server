<?php
namespace App\Models\Common\Module\Information;

use App\Models\Base;
use App\Http\Constant\Status;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 资讯收藏模型类
 */
class Collection extends Base
{
  // 表名
  protected $table = "module_information_collection";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'organization_id',
    'information_id',
    'member_id',
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-11
   * ------------------------------------------
   * 资讯收藏与资讯关联函数
   * ------------------------------------------
   *
   * 资讯收藏与资讯关联函数
   *
   * @return [关联对象]
   */
  public function information()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Information',
      'information_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-01-11
   * ------------------------------------------
   * 资讯收藏与学员关联函数
   * ------------------------------------------
   *
   * 资讯收藏与学员关联函数
   *
   * @return [关联对象]
   */
  public function member()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Member',
      'member_id',
      'id'
    );
  }
}
