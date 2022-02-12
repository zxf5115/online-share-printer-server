<?php
namespace App\Http\Controllers\Platform\Module\Common;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-01-14
 *
 * 主流银行控制器类
 */
class BankController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Common\Module\Common\Bank';

  // 客户端搜索字段
  protected $_params = [
    'code',
    'name'
  ];

  // 排序方式
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对象
  protected $_relevance = false;


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2022-01-14
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
      'logo.required' => '请您上传银行Logo',
      'name.required' => '请您输入银行名称',
    ];

    $rule = [
      'logo' => 'required',
      'name' => 'required',
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
        $model->logo = $request->logo;
        $model->code = $request->code ?? '';
        $model->name = $request->name;
        $model->color = $request->color ?? '';
        $model->sort = $request->sort ?? 0;
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
