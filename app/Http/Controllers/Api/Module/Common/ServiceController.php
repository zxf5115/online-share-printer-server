<?php
namespace App\Http\Controllers\Api\Module\Common;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-30
 *
 * 联系客服控制器类
 */
class ServiceController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\System\Config';

  // 默认查询条件
  protected $_where = [
    'category_id' => 9
  ];


  /**
   * @api {post} /api/common/service/data 11. 客服联系方式
   * @apiDescription 获取客服联系方式
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} service_mobile 客服电话
   * @apiSuccess (basic params) {String} service_wechat 客服微信号
   *
   * @apiSampleRequest /api/common/service/data
   * @apiVersion 1.0.0
   */
  public function data(Request $request)
  {
    try
    {
      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($this->_where, $filter);

      $response = $this->_model::getPluck(['value', 'title'], $condition);

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
