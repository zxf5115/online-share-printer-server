<?php
namespace App\Models\Common\Module\Currency;

use App\Models\Base;
use App\Enum\Module\Currency\CategoryEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币种类模型类
 */
class Category extends Base
{
  // 表名
  protected $table = "module_currency_category";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];

  /**
   * 转换属性类型
   */
  protected $casts = [
    'status' => 'array',
    'issue_time' => 'datetime:Y-m-d H:i:s',
    'create_time' => 'datetime:Y-m-d H:i:s',
    'update_time' => 'datetime:Y-m-d H:i:s',
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
   * ------------------------------------------
   * 是否热门货币封装
   * ------------------------------------------
   *
   * 是否热门货币封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsHotAttribute($value)
  {
    return CategoryEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
   * ------------------------------------------
   * 是否主流货币封装
   * ------------------------------------------
   *
   * 是否主流货币封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsMainAttribute($value)
  {
    return CategoryEnum::getStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
   * ------------------------------------------
   * 是否DeFi货币封装
   * ------------------------------------------
   *
   * 是否DeFi货币封装
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getIsDefiAttribute($value)
  {
    return CategoryEnum::getStatus($value);
  }
}
