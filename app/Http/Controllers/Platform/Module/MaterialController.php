<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-13
 *
 * 耗材控制器类
 */
class MaterialController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Material';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
  ];

  // 关联对象
  protected $_relevance = [
    'category',
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-09-13
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
      'category_id.required' => '请您选择耗材分类',
      // 'member_id.required'   => '请您选择所属店长',
      'total.required'       => '请您输入耗材数量',
    ];

    $rule = [
      'category_id' => 'required',
      // 'member_id'   => 'required',
      'total'       => 'required',
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
        // $model->member_id       = $request->member_id;
        $model->total           = $request->total;
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
