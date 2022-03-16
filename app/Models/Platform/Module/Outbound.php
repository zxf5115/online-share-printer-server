<?php
namespace App\Models\Platform\Module;

use App\Models\Platform\Module\Organization;
use App\Models\Platform\Module\Outbound\Detail;
use App\Models\Common\Module\Outbound as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-10-06
 *
 * 出库模型类
 */
class Outbound extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'username',
    'actual_total',
    'abnormal_status',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 所属打印机封装
   * ------------------------------------------
   *
   * 所属打印机封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getUsernameAttribute($value)
  {
    $response = '';

    $result = Organization::getRow(['id' => $this->member_id]);

    if(!empty($result->username))
    {
      $response = $result->username ?: '';
    }

    return $response;
  }


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
      'outbound_id' => $this->id,
    ];

    return Detail::getCount($where);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-03-14
   * ------------------------------------------
   * 出库状态封装
   * ------------------------------------------
   *
   * 出库状态封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getAbnormalStatusAttribute($value)
  {
    $response = [
      'text' => '出库异常',
      'value' => 2
    ];

    if($this->total == $this->actual_total)
    {
      $response = [
        'text' => '出库正常',
        'value' => 1
      ];
    }

    return $response;
  }
}
