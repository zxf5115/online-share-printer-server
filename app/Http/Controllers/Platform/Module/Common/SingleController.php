<?php
namespace App\Http\Controllers\Platform\Module\Common;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-10
 *
 * 唯一数据控制器类
 */
class SingleController extends BaseController
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-10
   * ------------------------------------------
   * 获取审核状态数据
   * ------------------------------------------
   *
   * 获取审核状态数据
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function audit(Request $request)
  {
    $response = [
      ['id' => 0, 'title' => '待审核'],
      ['id' => 1, 'title' => '审核通过'],
      ['id' => 2, 'title' => '审核不通过'],
    ];

    return self::success($response);
  }
}
