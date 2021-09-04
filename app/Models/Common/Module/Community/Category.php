<?php
namespace App\Models\Common\Module\Community;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-21
 *
 * 社区分类模型类
 */
class Category extends Base
{
  // 表名
  protected $table = "module_community_category";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-21
   * ------------------------------------------
   * 社区分类与社区关联函数
   * ------------------------------------------
   *
   * 社区分类与社区关联函数
   *
   * @return [关联对象]
   */
  public function community()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Community',
      'community_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-02
   * ------------------------------------------
   * 社区分类与货币交易对关联函数
   * ------------------------------------------
   *
   * 社区分类与货币交易对关联函数
   *
   * @return [关联对象]
   */
  public function symbol()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Currency\symbol',
      'symbol_id',
      'id'
    );
  }
}
