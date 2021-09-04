<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Enum\Module\Member\MoneyEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员收支模型类
 */
class Money extends Base
{
  // 表名
  public $table = "module_member_money";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'organization_id',
    'member_id',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-11
   * ------------------------------------------
   * 收支类型封装
   * ------------------------------------------
   *
   * 收支类型封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getTypeAttribute($value)
  {
    return MoneyEnum::getTypeStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 确认状态封装
   * ------------------------------------------
   *
   * 确认状态封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getConfirmStatusAttribute($value)
  {
    return MoneyEnum::getConfirmStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 支付类型封装
   * ------------------------------------------
   *
   * 支付类型封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getPayTypeAttribute($value)
  {
    return MoneyEnum::getPayType($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-11
   * ------------------------------------------
   * 会员收支与会员关联表
   * ------------------------------------------
   *
   * 会员收支与会员关联表
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
