<?php
namespace App\Enum\Module\Flash;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-22
 *
 * 快讯枚举类
 */
class FlashEnum extends BaseEnum
{
  // 审核状态
  const WAIT    = 0;
  const SUCCESS = 1;
  const ERROR   = 2;

  // 推荐
  const YES = 1;
  const NO  = 2;

  // 推荐
  public static $status = [
    self::YES => [
      'value' => self::YES,
      'text' => '是'
    ],

    self::NO => [
      'value' => self::NO,
      'text' => '否'
    ]
  ];

  // 快讯利益
  public static $audit = [
    self::WAIT => [
      'value' => self::WAIT,
      'text' => '待审核'
    ],

    self::SUCCESS => [
      'value' => self::SUCCESS,
      'text' => '审核通过'
    ],

    self::ERROR => [
      'value' => self::ERROR,
      'text' => '审核不通过'
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-10
   * ------------------------------------------
   * 推荐状态值
   * ------------------------------------------
   *
   * 推荐状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::NO];
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-10
   * ------------------------------------------
   * 审核状态状态值
   * ------------------------------------------
   *
   * 审核状态状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getAuditStatus($code)
  {
    return self::$audit[$code] ?: self::$audit[self::WAIT];
  }
}
