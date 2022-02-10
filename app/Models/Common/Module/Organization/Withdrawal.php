<?php
namespace App\Models\Common\Module\Organization;

use App\Models\Base;
use App\Enum\Module\Organization\WithdrawalEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-25
 *
 * 机构提现模型类
 */
class Withdrawal extends Base
{
  // 表名
  public $table = "module_organization_withdrawal";

  // 可以批量修改的字段
  public $fillable = [
    'id',
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
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 提现方式类型封装
   * ------------------------------------------
   *
   * 提现方式类型封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getPayTypeAttribute($value)
  {
    return WithdrawalEnum::getPayType($value);
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
    return WithdrawalEnum::getConfirmStatus($value);
  }

  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 代理商提现与代理商关联表
   * ------------------------------------------
   *
   * 代理商提现与代理商关联表
   *
   * @return [关联对象]
   */
  public function organization()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization',
      'member_id',
      'id'
    );
  }
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-25
   * ------------------------------------------
   * 代理商提现与代理商银行关联表
   * ------------------------------------------
   *
   * 代理商提现与代理商银行关联表
   *
   * @return [关联对象]
   */
  public function bank()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Organization\Bank',
      'member_id',
      'member_id'
    );
  }
}
