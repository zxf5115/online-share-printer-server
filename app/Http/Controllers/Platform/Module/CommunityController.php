<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-21
 *
 * 社区控制器类
 */
class CommunityController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Common\Module\Community';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
    'title',
    'create_time',
  ];

  // 关联对象
  protected $_relevance = [
    'list' => [
      'category'
    ],
    'select' => false,
    'view' => [
      'category'
    ],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-10
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
      'category_id.required' => '请您选择分类标题',
      'title.required'       => '请您输入社区标题',
      'content.required'     => '请您输入社区内容',
    ];

    $rule = [
      'category_id' => 'required',
      'title'       => 'required',
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
      try
      {
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $model->organization_id = self::getOrganizationId();
        $model->category_id     = $request->category_id;
        $model->member_id       = 1;
        $model->title           = $request->title;
        $model->picture         = $request->picture ?? '';
        $model->content         = $request->content;
        $model->author          = $request->author ?? '';
        $model->is_hot          = $request->is_hot ?? 2;
        $model->is_recommend    = $request->is_recommend ?? 2;
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
