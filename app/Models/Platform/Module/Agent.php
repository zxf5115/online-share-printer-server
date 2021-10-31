<?php
namespace App\Models\Platform\Module;

use App\Http\Constant\Code;
use App\Models\Common\Module\Organization as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 代理商模型类
 */
class Agent extends Common
{
  // 追加到模型数组表单的访问器
  protected $appends = [
    'printer',
    'below_agent_total',
    'below_manager_total',
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
  public function getPrinterAttribute($value)
  {
    if(1 == $this->level['value'])
    {
      $response = $this->first()->get();
    }
    else
    {
      $response = $this->second()->get();
    }

    return $response;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 下属代理商封装
   * ------------------------------------------
   *
   * 下属代理商封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getBelowAgentTotalAttribute($value)
  {
    $where = [
      'status'    => 1,
      'role_id'   => 3,
      'parent_id' => $this->id
    ];

    return self::where($where)->count();
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 下属店长封装
   * ------------------------------------------
   *
   * 下属店长封装
   *
   * @param [type] $value [description]
   * @return [type]
   */
  public function getBelowManagerTotalAttribute($value)
  {
    $where = [
      'status'    => 1,
      'role_id'   => 2,
      'parent_id' => $this->id
    ];

    return self::where($where)->count();
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-29
   * ------------------------------------------
   * 获得代理商级别名称
   * ------------------------------------------
   *
   * 获得代理商级别名称
   *
   * @param [type] $value 代理商级别
   * @return [type]
   */
  public static function getLevelName($value = 1)
  {
    $name = [
      1 => '一级代理',
      2 => '二级代理',
      3 => '三级代理',
    ];

    return $name[$value];
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
   * @param [type] $status 状态
   * @return [type]
   */
  public static function getCountData($level = 0)
  {
    $where = [
      'status'  => 1,
      'role_id' => 3
    ];

    if($level)
    {
      $where['level'] = $level;
    }

    return self::getCount($where);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-10-31
   * ------------------------------------------
   * 获取一级分销商编号
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param [type] $level [description]
   * @param [type] $mobile [description]
   * @return [type]
   */
  public static function getParentAgentId($level, $mobile)
  {
    if(1 == $level)
    {
      $response = [
        'status' => true,
        'code'   => 0
      ];
    }
    else if(2 == $level)
    {
      if(empty($mobile))
      {
        $response = [
          'status' => false,
          'code'   => Code::PARENT_AGENT_USERNAME_NO_EMPTY
        ];
      }
      else
      {
        $result = self::getRow(['username' => $mobile, 'level' => 1, 'status' => 1]);

        if(empty($result->id))
        {
          $response = [
            'status' => false,
            'code'   => Code::PARENT_AGENT_NO_EXITS
          ];
        }
        else
        {
          $response = [
            'status' => true,
            'code'   => $result->id
          ];
        }
      }
    }

    return $response;
  }






  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-24
   * ------------------------------------------
   * 代理商与打印机关联函数
   * ------------------------------------------
   *
   * 代理商与打印机关联函数
   *
   * @return [关联对象]
   */
  public function printer()
  {
    return $this->belongsToMany(
      'App\Models\Common\Module\Printer',
      'module_member_printer',
      'member_id',
      'printer_id',
    )->withPivot('use_status');
  }
}
