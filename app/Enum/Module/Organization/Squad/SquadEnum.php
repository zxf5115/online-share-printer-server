<?php
namespace App\Enum\Module\Organization\Squad;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-20
 *
 * 班级枚举类
 */
class SquadEnum
{
  // 审核状态
  const WAITING_AUDIT = 0;
  const AUDIT_PASS = 1;
  const AUDIT_NO_PASS = 2;


  // 审核封装
  public static $audit = [
    self::WAITING_AUDIT => [
      'value' => self::WAITING_AUDIT,
      'text' => '待审核'
    ],

    self::AUDIT_PASS => [
      'value' => self::AUDIT_PASS,
      'text' => '审核通过'
    ],

    self::AUDIT_NO_PASS => [
      'value' => self::AUDIT_NO_PASS,
      'text' => '审核拒绝'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
   * ------------------------------------------
   * 审核状态类型封装
   * ------------------------------------------
   *
   * 审核状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getAuditStatus($code)
  {
    return self::$audit[$code] ?: self::$audit[self::WAITING_AUDIT];
  }

}
