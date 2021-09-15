<?php
namespace App\Models\Common\Module\Agent;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-16
 *
 * 代理商分成比例模型类
 */
class Ratio extends Base
{
  // 表名
  protected $table = "module_agent_ratio";

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
   * @dateTime 2021-06-07
   * ------------------------------------------
   * 广告位置与广告关联函数
   * ------------------------------------------
   *
   * 广告位置与广告关联函数
   *
   * @return [关联对象]
   */
  public function advertising()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Advertising',
      'position_id',
      'id'
    );
  }
}
