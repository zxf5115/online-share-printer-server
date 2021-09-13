<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 报修控制器类
 */
class RepairController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Repair';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
  ];

  // 关联对象
  protected $_relevance = [
    'category',
    'member',
  ];
}
