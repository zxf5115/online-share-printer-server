<?php
namespace App\Http\Controllers\Platform\Module\Inbound;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-17
 *
 * 入库异常控制器类
 */
class AbnormalController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Inbound\Abnormal';

  // 客户端搜索字段
  protected $_params = [
    'inbound_id',
  ];

  // 关联对象
  protected $_relevance = [
    'inbound'
  ];
}
