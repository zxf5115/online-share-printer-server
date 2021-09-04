<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;
use App\Models\Platform\System\User\Message;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-17
 *s
 * 站内信控制器类
 */
class MessageController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\System\Message';

  // 排序方式
  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对象
  protected $_relevance = [
    'user',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-25
   * ------------------------------------------
   * 新增系统消息
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function handle(Request $request)
  {
    $messages = [
      'type.required'    => '请您输入消息类型',
      'title.required'   => '请您输入标题',
      'content.required' => '请您输入内容',
    ];

    $rule = [
      'title' => 'required',
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
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $organization_id = self::getOrganizationId();
        $current_id = self::getCurrentId();

        $model->organization_id = $organization_id;
        $model->type        = intval($request->type);
        $model->title       = $request->title;
        $model->content     = strval($request->content);
        $model->accept_type = $request->accept_type;
        $model->author      = $request->author;

        // 获取推送用户
        $users = $this->_model::getUsers($request, $current_id, $organization_id);

        $response = $model->save();

        $model->relevance()->delete();

        $relevance = $model->relevance()->createMany($users);

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



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-23
   * ------------------------------------------
   * 获取消息类型
   * ------------------------------------------
   *
   * 获取消息类型
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function type(Request $request)
  {
    try
    {
      $response = $this->_model::getTypeTextList();

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
