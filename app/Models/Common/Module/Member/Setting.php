<?php
namespace App\Models\Common\Module\Member;

use App\Models\Base;
use App\Enum\Module\Member\SettingEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员设置模型类
 */
class Setting extends Base
{
  // 表名
  public $table = "module_member_setting";

  // 可以批量修改的字段
  public $fillable = ['id'];

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
   * 订单开关封装
   * ------------------------------------------
   *
   * 推送开关封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getPushSwitchAttribute($value)
  {
    return SettingEnum::getSwitchStatus($value);
  }
}
