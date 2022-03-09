<?php
namespace App\Models\Platform\Module;

use App\Models\Common\Module\Printer as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-04
 *
 * 打印机模型类
 */
class Printer extends Common
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获取打印机数量
   * ------------------------------------------
   *
   * 获取打印机数量
   *
   * @param [type] $status 状态
   * @return [type]
   */
  public static function getCountData($value = 0, $field = 'status')
  {
    $where = [
      ['status', '>', '-1']
    ];

    if($value)
    {
      $where[$field] = $value;
    }

    return self::getCount($where);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获得设备信息
   * ------------------------------------------
   *
   * 获得设备信息
   *
   * @return [type]
   */
  public static function getEquipmentData()
  {
    try
    {
      $response = [];

      $result = self::getList([]);

      $key = 0;

      foreach($result as $item)
      {
        $province_id   = $item->province_id['value'];

        $province_name = $item->province_id['text'];

        if(empty($response[$province_id]))
        {
          $response[$province_id]['位置'] = $province_name;
          $response[$province_id]['在线'] = 0;
          $response[$province_id]['离线'] = 0;
          $response[$province_id]['故障'] = 0;

          if(1 == $item->activate_status['value'])
          {
            $response[$province_id]['在线'] += 1;
          }
          else if(2 == $item->activate_status['value'])
          {
            $response[$province_id]['离线'] += 1;
          }
          else if(3 == $item->activate_status['value'])
          {
            $response[$province_id]['故障'] += 1;
          }
        }
        else
        {
          if(1 == $item->activate_status['value'])
          {
            $response[$province_id]['在线'] += 1;
          }
          else if(2 == $item->activate_status['value'])
          {
            $response[$province_id]['离线'] += 1;
          }
          else if(3 == $item->activate_status['value'])
          {
            $response[$province_id]['故障'] += 1;
          }
        }
      }

      $response = array_values($response);

      return $response;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
