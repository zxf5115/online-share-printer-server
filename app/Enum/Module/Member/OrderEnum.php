<?php
namespace App\Enum\Module\Member;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-30
 *
 * 会员订单枚举类
 */
class OrderEnum extends BaseEnum
{
  // 支付类型
  const ALIPAY = 1; // 支付宝支付
  const WECHAT = 2; // 微信支付

  // 支付状态
  const PAY_WAIT = 0; // 待支付
  const PAY_FINISH = 1; // 已支付

  // 订单类型
  const WAIT         = 0; // 待派发
  const DISTRIBUTION = 1; // 派单中
  const TRANSPORT    = 2; // 运送中
  const FINISH       = 3; // 已完成
  const CANCEL       = 4; // 已取消


  // 支付类型封装
  public static $type = [
    self::ALIPAY => [
      'value' => self::ALIPAY,
      'text' => '支付宝支付'
    ],

    self::WECHAT => [
      'value' => self::WECHAT,
      'text' => '微信支付'
    ],
  ];


  // 支付状态封装
  public static $pay = [
    self::PAY_WAIT => [
      'value' => self::PAY_WAIT,
      'text' => '待支付'
    ],

    self::PAY_FINISH => [
      'value' => self::PAY_FINISH,
      'text' => '已支付'
    ],
  ];


  // 订单类型封装
  public static $order = [
    self::WAIT => [
      'value' => self::WAIT,
      'text' => '待派发'
    ],

    self::DISTRIBUTION => [
      'value' => self::DISTRIBUTION,
      'text' => '派单中'
    ],

    self::TRANSPORT => [
      'value' => self::TRANSPORT,
      'text' => '运送中'
    ],

    self::FINISH => [
      'value' => self::FINISH,
      'text' => '已完成'
    ],

    self::CANCEL => [
      'value' => self::CANCEL,
      'text' => '已取消'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-30
   * ------------------------------------------
   * 会员支付类型封装
   * ------------------------------------------
   *
   * 会员支付类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getTypeStatus($code)
  {
    return self::$type[$code] ?: self::$type[self::ALIPAY];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-30
   * ------------------------------------------
   * 会员支付状态封装
   * ------------------------------------------
   *
   * 会员支付状态封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getPayStatus($code)
  {
    return self::$pay[$code] ?: self::$pay[self::PAY_WAIT];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-12-30
   * ------------------------------------------
   * 会员订单状态封装
   * ------------------------------------------
   *
   * 会员订单状态封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getOrderStatus($code)
  {
    return self::$order[$code] ?: self::$order[self::WAIT];
  }
}
