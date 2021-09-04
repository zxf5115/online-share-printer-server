<?php
namespace App\Enum\Module\Currency;

use App\Enum\BaseEnum;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币种类枚举类
 */
class CategoryEnum extends BaseEnum
{
  // 课程推荐
  const YES = 1;
  const NO  = 2;

  // 课程推荐
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

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
   * ------------------------------------------
   * 状态值
   * ------------------------------------------
   *
   * 状态值
   *
   * @param int $code 信息代码
   * @return 信息内容
   */
  public static function getStatus($code)
  {
    return self::$status[$code] ?: self::$status[self::NO];
  }
}
