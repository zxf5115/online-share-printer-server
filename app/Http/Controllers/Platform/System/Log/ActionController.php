<?php
namespace App\Http\Controllers\Platform\System\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Constant\Code;
use App\Http\Constant\Parameter;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-09-23
 *
 * 平台行为日志控制器类
 */
class ActionController extends BaseController
{
  protected $_model = 'App\Models\Platform\System\Log\Action';

  protected $_where = [];

  protected $_params = [
    'username',
    'create_time'
  ];

  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  protected $_relevance = [];
}
