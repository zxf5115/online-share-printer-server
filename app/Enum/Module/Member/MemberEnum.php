<?php
namespace App\Enum\Module\Member;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-20
 *
 * 会员枚举类
 */
class MemberEnum
{
  // 状态
  const WAIT  = 0; // 等待
  const ENABLE  = 1; // 解禁
  const DISABLE = 2; // 禁用
  const DELETE  = -1; // 禁用

  // 冻结
  const FREEZE = 1; // 冻结
  const THAW = 2;  // 解冻


  const FIRST  = 1; // 一级代理
  const SECOND = 2; // 二级代理


  // 状态封装
  public static $status = [
    self::ENABLE => [
      'value' => self::ENABLE,
      'text' => '解禁'
    ],

    self::DISABLE => [
      'value' => self::DISABLE,
      'text' => '禁用'
    ],

    self::DELETE => [
      'value' => self::DELETE,
      'text' => '删除'
    ]
  ];


  // 审核状态封装
  public static $audit = [
    self::WAIT => [
      'value' => self::WAIT,
      'text' => '待审核'
    ],

    self::ENABLE => [
      'value' => self::ENABLE,
      'text' => '审核通过'
    ],

    self::DISABLE => [
      'value' => self::DISABLE,
      'text' => '审核不通过'
    ]
  ];

  // 冻结状态封装
  public static $freeze = [
    self::FREEZE => [
      'value' => self::FREEZE,
      'text' => '冻结'
    ],

    self::THAW => [
      'value' => self::THAW,
      'text' => '解冻'
    ]
  ];


  // 技能水平状态封装
  public static $level = [
    self::WAIT => [
      'value' => self::WAIT,
      'text' => '暂无'
    ],

    self::FIRST => [
      'value' => self::FIRST,
      'text' => '一级代理'
    ],

    self::SECOND => [
      'value' => self::SECOND,
      'text' => '二级代理'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
   * ------------------------------------------
   * 技能水平状态类型封装
   * ------------------------------------------
   *
   * 技能水平状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getLevelStatus($code)
  {
    return self::$level[$code] ?: self::$level[self::FIRST];
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
   * ------------------------------------------
   * 状态类型封装
   * ------------------------------------------
   *
   * 状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::ENABLE];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-20
   * ------------------------------------------
   * 用户状态类型封装
   * ------------------------------------------
   *
   * 用户状态类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getFreezeStatus($code)
  {
    return self::$freeze[$code] ?: self::$freeze[self::THAW];
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
    return self::$audit[$code] ?: self::$audit[self::WAIT];
  }

}
