<?php
namespace App\Models\Platform\Module;

use App\Models\Platform\Module\Organization;
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
}
