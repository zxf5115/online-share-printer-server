<?php
namespace App\Http\Controllers\Platform\Module\Currency;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-28
 *
 * 货币种类控制器类
 */
class CategoryController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Currency\Category';

  // 客户端搜索字段
  protected $_params = [
    'slug',
    'symbol',
    'fullname',
  ];

  // 排序条件
  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-27
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
      'slug.required'   => '请您输入币种名称',
      'symbol.required' => '请您输入币种符号',
    ];

    $rule = [
      'slug'   => 'required',
      'symbol' => 'required',
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

        $model->organization_id  = self::getOrganizationId();
        $model->slug             = $request->slug;
        $model->symbol           = $request->symbol;
        $model->fullname         = $request->fullname;
        $model->logo_url         = $request->logo_url;
        $model->market_cap_usd   = $request->market_cap_usd;
        $model->available_supply = $request->available_supply;
        $model->total_supply     = $request->total_supply;
        $model->max_supply       = $request->max_supply;
        $model->issue_time       = strtotime($request->issue_time);
        $model->is_hot           = $request->is_hot;
        $model->is_main          = $request->is_main;
        $model->is_defi          = $request->is_defi;
        $model->sort             = $request->sort ?? 0;
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


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-28
   * ------------------------------------------
   * 启用（停用）货币类型
   * ------------------------------------------
   *
   * 启用（停用）货币类型
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function status(Request $request)
  {
    try
    {
      $model = $this->_model::find($request->id);

      $field = $request->field;

      $model->$field = $request->value;
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
