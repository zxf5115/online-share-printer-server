<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 我的客服控制器类
 */
class ContactController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Contact';


  /**
   * @api {post} /api/member/contact/handle 01. 提交联系客服信息
   * @apiDescription 提交联系客服信息信息
   * @apiGroup 26. 会员客服模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} title 投诉类型
   * @apiParam {string} content 投诉内容
   * @apiParam {string} name 投诉内容
   * @apiParam {string} email 投诉内容
   *
   * @apiSampleRequest /api/member/contact/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'title.required'   => '请您输入主题',
      'content.required' => '请您输入内容',
      'name.required'    => '请您输入联系人',
      'email.required'   => '请您输入邮箱',
    ];

    $rule = [
      'title'   => 'required',
      'content' => 'required',
      'name'    => 'required',
      'email'   => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      try
      {
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $model->member_id = self::getCurrentId();
        $model->title     = $request->title;
        $model->content   = $request->content;
        $model->name      = $request->name;
        $model->email     = $request->email;
        $model->save();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
