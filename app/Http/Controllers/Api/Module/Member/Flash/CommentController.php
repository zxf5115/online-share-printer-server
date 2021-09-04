<?php
namespace App\Http\Controllers\Api\Module\Member\Flash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员快讯评论控制器类
 */
class CommentController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Flash\Comment';


  /**
   * @api {post} /api/member/flash/comment/handle 02. 快讯评论操作
   * @apiDescription 当前会员执行快讯评论操作
   * @apiGroup 52. 快讯评论模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} flash_id 快讯编号
   * @apiParam {string} [parent_id] 上级评论编号, 0为初始评论
   * @apiParam {string} [comment_id] 基础评论编号, 0为初始评论
   * @apiParam {string} be_member_id 被评论人编号
   * @apiParam {string} content 评论内容
   *
   * @apiSampleRequest /api/member/flash/comment/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'flash_id.required' => '请您输入快讯编号',
      'content.required'  => '请您输入评论内容',
    ];

    $rule = [
      'flash_id' => 'required',
      'content'  => 'required',
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $model = new $this->_model();

        $model->parent_id    = $request->parent_id ?? 0;
        $model->comment_id   = $request->comment_id ?? 0;
        $model->flash_id     = $request->flash_id;
        $model->be_member_id = $request->be_member_id ?? 0;
        $model->member_id    = self::getCurrentId();
        $model->content      = $request->content;
        $model->save();

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
