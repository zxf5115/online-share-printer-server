<?php
namespace App\Models\Platform\Module\Member\Certification;

use App\Models\Common\Module\Member\Certification\Project as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员项目认证模型类
 */
class Project extends Common
{

  // 追加到模型数组表单的访问器
  protected $appends = [
    'project_category'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-20
   * ------------------------------------------
   * 项目分类封装
   * ------------------------------------------
   *
   * 项目分类封装
   *
   * @param int $value 状态值
   * @return 状态信息
   */
  public function getProjectCategoryAttribute($value)
  {
    $response = '';

    if(!empty($this->category))
    {
      $response = $this->category->title;

      unset($this->category);
    }

    return $response;
  }
}
