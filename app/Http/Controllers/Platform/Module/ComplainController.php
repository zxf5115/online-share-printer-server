<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-11
 *
 * 广告控制器类
 */
class ComplainController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Complain';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
  ];

  // 关联对象
  protected $_relevance = [
    'category'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-10
   * ------------------------------------------
   * 阅读投诉
   * ------------------------------------------
   *
   * 阅读投诉
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function read(Request $request)
  {
    try
    {
      $model = $this->_model::find($request->id);

      $model->read_status = 1;

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
