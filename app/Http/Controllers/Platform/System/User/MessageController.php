<?php
namespace App\Http\Controllers\Platform\System\User;

use Illuminate\Http\Request;

use App\Enum\BaseEnum;
use App\Http\Constant\Code;
use App\Models\Platform\System\User\UserMessage;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-17
 *
 * 用户消息控制器类
 */
class MessageController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\System\User';

  // 客户端搜索字段
  protected $_params = [
    'title',
  ];

  protected $_addition = [
    'message' => [
      'status'
    ]
  ];

  // 关联对象
  protected $_relevance = [
    'list' => [
      'message'
    ]
  ];

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-17
   * ------------------------------------------
   * 当前用户消息
   * ------------------------------------------
   *
   * 当前用户消息
   *
   * @param Request $request 请求数据
   * @return [type]
   */
  public function list(Request $request)
  {
    try
    {
      // 默认查询字段
      $request['message_status'] = BaseEnum::ENABLE;

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = ['user_id' => self::getCurrentId()];

      $where = ['status' => BaseEnum::ENABLE];

      $where = array_merge($condition, $where, $filter);

      $relevance = self::getRelevanceData($this->_relevance, 'list');

      $unread = UserMessage::getList($where, $relevance);

      $unread_count = count($unread) > 0 ? count($unread) : '';

      $where = ['status' => BaseEnum::DISABLE];

      $where = array_merge($condition, $where, $filter);

      $readed = UserMessage::getPaging($where, $relevance);

      $response = [
        'unread'       => $unread,
        'unread_count' => $unread_count,
        'readed'       => $readed,
      ];

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::HANDLE_FAILURE);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-17
   * ------------------------------------------
   * 是否存在未读消息
   * ------------------------------------------
   *
   * 是否存在未读消息
   *
   * @param Request $request 请求数据
   * @return [type]
   */
  public function unread(Request $request)
  {
    try
    {
      $where = [
        'user_id' => self::getCurrentId(),
        'status'  => BaseEnum::ENABLE
      ];

      $response = UserMessage::getCount($where);

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::HANDLE_FAILURE);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-17
   * ------------------------------------------
   * 消息设置为已读
   * ------------------------------------------
   *
   * 消息设置为已读
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function readed(Request $request)
  {
    try
    {
      $id = $request->id ?? 0;

      $current_id = self::getCurrentId();

      // 设置为已读
      UserMessage::setReaded($id, $current_id);

      return self::success(Code::HANDLE_SUCCESS);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::HANDLE_FAILURE);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-17
   * ------------------------------------------
   * 删除已读消息
   * ------------------------------------------
   *
   * 删除已读消息
   *
   * @param Request $request 请求数据
   * @return [type]
   */
  public function delete(Request $request)
  {
    try
    {
      $id = $request->id ?? '';

      $user_id = self::getCurrentId();

      // 删除已读
      UserMessage::setDelete($id, $user_id);

      return self::success(Code::HANDLE_SUCCESS);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::HANDLE_FAILURE);
    }
  }
}
