<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-25
 *
 * 分享红包控制器类
 */
class ShareController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\System\Config';

  // 默认查询条件
  protected $_where = [
    'category_id' => 3
  ];


  /**
   * @api {post} /api/member/share/data 01. 会员分享数据
   * @apiDescription 获取学员分享配置
   * @apiGroup 32. 会员分享模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {String} invitation_code 邀请码
   * @apiSuccess (字段说明) {String} invitation_content 邀请说明
   * @apiSuccess (字段说明) {String} qrcode 二维码图片
   *
   * @apiSampleRequest /api/member/share/data
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

      $member_id = self::getCurrentId();

      $response['invitation_code'] = 'BMW' . str_pad($member_id, 6, 0, STR_PAD_LEFT);
dd($response);
      $filename = md5(time() . rand(1, 9999999)). '.png';

      $uri = storage_path('app/public/qrcode/' . $filename);

      $web_url = $this->_model::getConfigValue('web_url');

      $url = $web_url . '/storage/qrcode/' . $filename;

      $params = 'http://h5.xcyys.cn/#/?course_id=';

      // 生成带有分享人信息的二维码
      QrCode::format('png')->size(300)->encoding('UTF-8')->generate($params, $uri);

      $response['qrcode'] = $url;

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
