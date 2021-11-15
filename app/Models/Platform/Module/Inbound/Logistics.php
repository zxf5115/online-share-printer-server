<?php
namespace App\Models\Platform\Module\Inbound;

use App\Models\Common\Module\Inbound\Logistics as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-17
 *
 * 入库物流模型类
 */
class Logistics extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'company_name',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-17
   * ------------------------------------------
   * 物流公司封装
   * ------------------------------------------
   *
   * 物流公司封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getCompanyNameAttribute($value)
  {
    $result = Company::getRow(['id' => $this->company_id]);

    $response = $result->name ?: '暂无';

    return $response;
  }
}
