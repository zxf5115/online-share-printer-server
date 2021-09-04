<?php
namespace App\Http\Controllers\Platform\Module\Currency;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币符号控制器类
 */
class SymbolController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Currency\Symbol';

  // 客户端搜索字段
  protected $_params = [
    'market',
    'symbol',
    'base_currency',
    'quote_currency',
  ];

  // 排序条件
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
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
      'symbol.required'         => '请您输入交易对',
      'base_currency.required'  => '请您输入交易对中的基础币种',
      'quote_currency.required' => '请您输入交易对中的报价币种',
    ];

    $rule = [
      'symbol'         => 'required',
      'base_currency'  => 'required',
      'quote_currency' => 'required',
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
        $model->market          = $request->market ?? '';
        $model->symbol          = $request->symbol;
        $model->base_currency   = $request->base_currency;
        $model->quote_currency  = $request->quote_currency;
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
