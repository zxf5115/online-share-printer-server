<?php
namespace App\Enum\Module\Organization;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-20
 *
 * 机构枚举类
 */
class OrganizationEnum
{
  // 认证状态
  const WAITING_CERTIFICATION = 0;
  const FINISH_CERTIFICATION = 1;

  const WAITING_AUDIT = 0;
  const AUDIT_PASS = 1;
  const AUDIT_NO_PASS = 2;

  // 认证封装
  public static $certification = [
    self::WAITING_CERTIFICATION => [
      'value' => self::WAITING_CERTIFICATION,
      'text' => '待认证'
    ],

    self::FINISH_CERTIFICATION => [
      'value' => self::FINISH_CERTIFICATION,
      'text' => '已认证'
    ]
  ];


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
   * 认证状态类型封装
   * ------------------------------------------
   *
   * 认证状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getCertificationStatus($code)
  {
    return self::$certification[$code] ?: self::$certification[self::WAITING_CERTIFICATION];
  }


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
