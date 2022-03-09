<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Organization as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-25
 *
 * 会员模型类
 */
class Manager extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'printer_total',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 打印机数量封装
   * ------------------------------------------
   *
   * 打印机数量封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getPrinterTotalAttribute($value)
  {
    return $this->manager()->count();
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取打印机数量
   * ------------------------------------------
   *
   * 获取打印机数量
   *
   * @return [type]
   */
  public static function getCountData()
  {
    $where = [
      ['status', '>', -1],
      'role_id' => 2
    ];

    return self::getCount($where);
  }
}
