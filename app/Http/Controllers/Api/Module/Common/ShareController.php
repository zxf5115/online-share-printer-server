<?php
namespace App\Http\Controllers\Api\Module\Common;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-30
 *
 * 分享控制器类
 */
class ShareController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\System\Config';

  // 默认查询条件
  protected $_where = [
    'category_id' => 4
  ];


  /**
   * @api {post} /api/common/share/data 10. 分享公共数据
   * @apiDescription 获取分享公共数据
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} share_qrcode 分享二维码
   * @apiSuccess (basic params) {String} share_content 分享内容
   *
   * @apiSampleRequest /api/common/share/data
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
