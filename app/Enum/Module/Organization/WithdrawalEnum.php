<?php
namespace App\Enum\Module\Organization;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-24
 *
 * 机构提现枚举类
 */
class WithdrawalEnum extends BaseEnum
{
  const FINISH = 1; //已确认
  const WAIT   = 2; // 待确认

  const NONE    = 0; // 无
  const WEIXIN  = 1; // 微信
  const ALIPAY  = 2; // 支付宝
  const BALANCE = 3; // 余额
  const APPLE   = 4; // 苹果


  // 确认状态封装
  public static $confirm = [
    self::FINISH => [
      'value' => self::FINISH,
      'text' => '已确认'
    ],

    self::WAIT => [
      'value' => self::WAIT,
      'text' => '待确认'
    ]
  ];

  // 确认状态封装
  public static $pay = [
    self::NONE => [
      'value' => self::NONE,
      'text' => '无'
    ],

    self::WEIXIN => [
      'value' => self::WEIXIN,
      'text' => '微信'
    ],

    self::ALIPAY => [
      'value' => self::ALIPAY,
      'text' => '支付宝'
    ],

    self::BALANCE => [
      'value' => self::BALANCE,
      'text' => '余额'
    ],

    self::APPLE => [
      'value' => self::APPLE,
      'text' => '苹果'
    ]
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-13
   * ------------------------------------------
   * 确认状态封装
   * ------------------------------------------
   *
   * 确认状态封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getConfirmStatus($code)
  {
    return self::$confirm[$code] ?: self::$confirm[self::WAIT];
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
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getPayType($code)
  {
    return self::$pay[$code] ?: self::$pay[self::NONE];
  }
}
