<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Inbound\Detail;
use App\Models\Common\Module\Inbound as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-06
 *
 * 入库单模型类
 */
class Inbound extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'actual_total',
    'abnormal_status',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-03-16
   * ------------------------------------------
   * 实际导入打印机数量封装
   * ------------------------------------------
   *
   * 实际导入打印机数量封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getActualTotalAttribute($value)
  {
    $where = [
      'inbound_id' => $this->id,
    ];

    return Detail::getCount($where);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-03-14
   * ------------------------------------------
   * 入库状态封装
   * ------------------------------------------
   *
   * 入库状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getAbnormalStatusAttribute($value)
  {
    $response = [
      'text' => '入库异常',
      'value' => 2
    ];

    if($this->total == $this->actual_total)
    {
      $response = [
        'text' => '入库正常',
        'value' => 1
      ];
    }

    return $response;
  }
}
