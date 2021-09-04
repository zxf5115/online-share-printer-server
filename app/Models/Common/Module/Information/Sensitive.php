<?php
namespace App\Models\Common\Module\Information;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-11
 *
 * 资讯敏感词模型类
 */
class Sensitive extends Base
{
  // 表名
  protected $table = "module_information_sensitive";

  // 隐藏的属性
  protected $hidden = [
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];

  // 批量添加
  protected $fillable = ['id'];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-14
   * ------------------------------------------
   * 屏蔽敏感词
   * ------------------------------------------
   *
   * 屏蔽敏感词
   *
   * @param [type] $content 输入内容
   * @return [type]
   */
  public static function shield($content)
  {
    try
    {
      $result = self::getPluck('title', ['status' => 1]);

      foreach($result as $item)
      {
        if(false !== strpos($content, $item))
        {
          $content = str_replace($item, '***', $content);
        }
      }

      return $content;
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  // 关联函数 ------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-09
   * ------------------------------------------
   * 资讯分类置与资讯关联函数
   * ------------------------------------------
   *
   * 资讯分类置与资讯关联函数
   *
   * @return [关联对象]
   */
  public function information()
  {
    return $this->hasMany(
      'App\Models\Common\Module\Information',
      'information_id',
      'id'
    );
  }
}
