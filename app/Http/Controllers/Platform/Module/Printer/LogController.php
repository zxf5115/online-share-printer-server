<?php
namespace App\Http\Controllers\Platform\Module\Printer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Models\Platform\Module\Printer;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-15
 *
 * 打印机日志控制器类
 */
class LogController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Printer\Log';

  // 客户端搜索字段
  protected $_params = [
    'printer_id',
    'content',
  ];

  // 排序条件
  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对象
  protected $_relevance = [
    'printer'
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
      'printer_id.required' => '请您输入打印机编号',
      'action.required'     => '请您输入操作行为',
    ];

    $rule = [
      'printer_id' => 'required',
      'action'     => 'required',
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
        $printer = Printer::getRow(['id' => $request->printer_id]);

        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $action = $request->action;

        if(1 == $action)
        {
          $printer->increment('paper_quantity', 10000);

          $content = '送纸张(x2)';
        }
        else if(2 == $action)
        {
          $printer->ink_quantity = 100;

          $content = '更换墨盒(x1)';
        }
        else if(3 == $action)
        {
          $content = '更换设备为';
        }

        $printer->save();

        $model->organization_id = self::getOrganizationId();
        $model->printer_id      = $request->printer_id;
        $model->type            = $action;
        $model->content         = $content;
        $model->operator        = self::getCurrentName();
        $model->save();

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
