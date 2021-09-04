<?php
namespace App\Http\Controllers\Platform\Module\Education;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-23
 *
 * 课件控制器类
 */
class CoursewareController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Education\Courseware';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
    'title',
    'create_time',
  ];

  // 排序方式
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对象
  protected $_relevance = [
    'list' => [
      'category'
    ]
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
      'category_id.required' => '请您输入课件分类',
      'teacher_id.required'  => '请您输入课件老师',
      'code.required'        => '请您输入课件编号',
      'title.required'       => '请您输入课件标题',
      'picture.required'     => '请您上传课件封面',
      'money.required'       => '请您输入课件价格',
    ];

    $rule = [
      'category_id' => 'required',
      'teacher_id'  => 'required',
      'code'        => 'required',
      'title'       => 'required',
      'picture'     => 'required',
      'money'       => 'required',
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
        $model->code            = $request->code;
        $model->title           = $request->title;
        $model->content         = $request->content;
        $model->picture         = $request->picture;
        $model->category_id     = $request->category_id;
        $model->teacher_id      = $request->teacher_id;
        $model->money           = $request->money;
        $model->is_shelf        = $request->is_shelf;
        $model->is_trial        = $request->is_trial;
        $model->is_recommend    = $request->is_recommend;
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
