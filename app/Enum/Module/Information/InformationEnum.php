<?php
namespace App\Enum\Module\Information;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-10
 *
 * 资讯枚举类
 */
class InformationEnum
{
  // 是否推荐状态
  const YES = 1; // 是
  const NO  = 2; // 否

  // 审核状态
  const WAIT    = 0;
  const SUCCESS = 1;
  const ERROR   = 2;

  // 是否推荐状态
  public static $status = [
    self::YES       => [
      'value' => self::YES,
      'text' => '是'
    ],

    self::NO       => [
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
   * @dateTime 2021-06-10
   * ------------------------------------------
   * 是否推荐状态封装
   * ------------------------------------------
   *
   * 是否推荐状态封装
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::YES];
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
