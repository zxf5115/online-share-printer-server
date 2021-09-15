<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-17
 *
 * 价格控制器类
 */
class PriceController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Common\Module\Price';

  // 客户端搜索字段
  protected $_params = [
    'title',
  ];

  // 排序方式
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-17
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
      'title.required' => '请您输入费用名称',
      'price.required' => '请您输入收费价格',
    ];

    $rule = [
      'title' => 'required',
      'price' => 'required',
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
        $model->price           = $request->price;
        $model->sort            = $request->sort ?? 0;
        $model->save();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        record($e);

        return self::error(Code::ERROR);
      }
    }
  }
}
