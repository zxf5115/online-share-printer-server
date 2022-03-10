<?php
namespace App\Http\Controllers\Platform\System\Config;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-03-10
 *
 * 系统协议控制器类
 */
class AgreementController extends BaseController
{
  protected $_model = 'App\Models\Platform\System\Config\Agreement';


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-19
   * ------------------------------------------
   * 获取数据详情
   * ------------------------------------------
   *
   * 获取数据详情
   *
   * @param Request $request 请求参数
   * @return [type]
   */
  public function data(Request $request)
  {
    try
    {
      $condition = self::getBaseWhereData($request->title, 'title');

      $response = $this->_model::getValue('content', $condition);

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
