<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Events\Common\Push\AuroraEvent;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-12
 *
 * 通知控制器类
 */
class NoticeController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Notice';

  // 默认查询条件
  protected $_where = [
    'category_id' => 1
  ];

  // 客户端搜索字段
  protected $_params = [
    'content',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-12
   * ------------------------------------------
   * 操作信息
   * ------------------------------------------
   *
   * 操作信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function handle(Request $request)
  {
    $messages = [
      'content.required'     => '请您输入通知内容',
    ];

    $rule = [
      'content'     => 'required',
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

        $model->organization_id = self::getOrganizationId();
        $model->category_id     = 1;
        $model->content         = $request->content;
        $model->save();

        $data = [
          'title'   => '系统公告',
          'content' => $request->content ?? ''
        ];

        // 消息推送
        event(new AuroraEvent(3, $data));

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        record($e);

        return self::error(Code::ERROR);
      }
    }
  }

}
