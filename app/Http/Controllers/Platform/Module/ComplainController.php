<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-01-11
 *
 * 投诉控制器类
 */
class ComplainController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Complain';


  // 关联对象
  protected $_relevance = [
    'list' => [
      'member',
    ],
    'select' => false,
    'view' => [
      'member',
      'resource',
    ],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-19
   * ------------------------------------------
   * 获取数据详情
   * ------------------------------------------
   *
   * 获取数据详情
   *
   * @param Request $request 请求参数
   * @param [type] $id 数据编号
   * @return [type]
   */
  public function view(Request $request, $id)
  {
    try
    {
      $condition = self::getBaseWhereData();

      $where = ['id' => $id];

      $condition = array_merge($condition, $where);

      $relevance = self::getRelevanceData($this->_relevance, 'view');

      $response = $this->_model::getRow($condition, $relevance);

      $response->read_status = 1;
      $response->save();

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }




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
