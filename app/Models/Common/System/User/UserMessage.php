<?php
namespace App\Models\Common\System\User;

use App\Models\Base;
use App\Enum\MessageEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-16
 *
 * 系统用户消息模型类
 */
class UserMessage extends Base
{
  // 表名
  public $table = 'system_user_message';

  /**
   * 可以被批量赋值的属性
   */
  public $fillable = [
    'id',
    'organization_id',
    'user_id',
    'message_id',
  ];

  // 隐藏的属性
  public $hidden = [
    'update_time'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 状态属性类型转换函数
   * ------------------------------------------
   *
   * 状态属性类型转换函数
   *
   * @param int $value [数据库存在的值]
   * @return 状态值
   */
  public function getStatusAttribute($value)
  {
    return MessageEnum::getReadStatus($value);
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 用户消息与用户关联函数
   * ------------------------------------------
   *
   * 用户消息与用户关联函数
   *
   * @return [关联对象]
   */
  public function user()
  {
    return $this->belongsTo(
      'App\Models\Common\System\User',
      'user_id',
      'id'
    );
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 用户消息与消息关联函数
   * ------------------------------------------
   *
   * 用户消息与消息关联函数
   *
   * @return [关联对象]
   */
  public function message()
  {
    return $this->belongsTo(
      'App\Models\Common\System\Message',
      'message_id',
      'id'
    )->where(['status' => 1]);
  }
}
