<?php
namespace App\Models\Common\Module\Currency;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-13
 *
 * 货币交易模型类
 */
class Optional extends Base
{
  // 表名
  protected $table = "module_currency_optional";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = [
    'id',
    'member_id',
    'symbol_id',
  ];



  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 自选货币与货币关联函数
   * ------------------------------------------
   *
   * 自选货币与货币关联函数
   *
   * @return [关联对象]
   */
  public function symbol()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Currency\Symbol',
      'symbol_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 自选货币与学员关联函数
   * ------------------------------------------
   *
   * 自选货币与学员关联函数
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
