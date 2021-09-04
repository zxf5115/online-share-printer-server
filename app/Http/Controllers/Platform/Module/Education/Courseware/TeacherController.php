<?php
namespace App\Http\Controllers\Platform\Module\Education\Courseware;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-24
 *
 * 课件老师控制器类
 */
class TeacherController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Education\Courseware\Teacher';

  // 客户端搜索字段
  protected $_params = [
    'title'
  ];

  // 排序方式
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-23
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
      'title.required'    => '请您输入讲师姓名',
      'picture.required'  => '请您上传讲师头像',
      'mobile.required'   => '请您输入讲师电话',
      'position.required' => '请您输入讲师头衔',
    ];

    $rule = [
      'title'    => 'required',
      'picture'  => 'required',
      'mobile'   => 'required',
      'position' => 'required',
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

        $model->organization_id = self::getOrganizationId();
        $model->title           = $request->title;
        $model->picture         = $request->picture;
        $model->mobile          = $request->mobile;
        $model->position        = $request->position;
        $model->content         = $request->content ?? '';
        $model->sort            = $request->sort ?? 0;
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
