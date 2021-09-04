<?php
namespace App\Models\Common\Module\Member\Certification;

use App\Models\Base;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员项目认证模型类
 */
class Project extends Base
{
  use \Awobaz\Compoships\Compoships;

  // 表名
  public $table = "module_member_certification_project";

  // 可以批量修改的字段
  public $fillable = [
    'id',
    'member_id',
    'project_name',
    'project_logo',
    'realname',
    'mobile',
    'category_id',
    'project_website',
    'project_document',
    'project_social',
    'project_report',
    'project_github',
  ];

  // 隐藏的属性
  public $hidden = [
    'status',
    'update_time'
  ];

  // 追加到模型数组表单的访问器
  protected $appends = [];


  // 关联函数 ------------------------------------------------------


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-08
   * ------------------------------------------
   * 项目认证与项目分类关联表
   * ------------------------------------------
   *
   * 项目认证与项目分类关联表
   *
   * @return [关联对象]
   */
  public function category()
  {
    return $this->belongsTo(
      'App\Models\Common\Module\Project\Category',
      'category_id',
      'id'
    );
  }
}
