<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-04
 *
 * 打印机控制器类
 */
class PrinterController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Common\Module\Printer';

  // 客户端搜索字段
  protected $_params = [
    'title',
    'status',
  ];

  // 关联对象
  protected $_relevance = [
    'list' => [
      'member'
    ],
    'select' => false,
    'view' => false,
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-04
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
      // 'member_id.required' => '请您选择所属者编号',
      'title.required'     => '请您输入打印机标题',
    ];

    $rule = [
      // 'member_id' => 'required',
      'title'     => 'required',
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
        $model->member_id       = $request->member_id;
        $model->title           = $request->title;
        $model->province_id     = $request->province_id ?? 0;
        $model->city_id         = $request->city_id ?? 0;
        $model->region_id       = $request->region_id ?? 0;
        $model->address         = $request->address ?? '';
        $model->remark          = $request->remark;
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
