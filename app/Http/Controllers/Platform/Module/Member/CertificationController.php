<?php
namespace App\Http\Controllers\Platform\Module\Member;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员认证控制器类
 */
class CertificationController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\Module\Member\Certification';

  // 关联对象
  protected $_relevance = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-19
   * ------------------------------------------
   * 认证数据
   * ------------------------------------------
   *
   * 认证数据
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function data(Request $request)
  {
    try
    {
      $model = $this->_model::getRow(['member_id' => $request->id]);

      $type = $request->type ?? 1;

      if(1 == $type)
      {
        $response = $model->personal ?? '';
      }
      else if(2 == $type)
      {
        $response = $model->company ?? '';
      }
      else if(3 == $type)
      {
        $response = $model->project ?? '';

      }

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::HANDLE_FAILURE);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 操作会员
   * ------------------------------------------
   *
   * 操作会员信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function handle(Request $request)
  {
    $messages = [
      'certification_id.required'      => '请您选择认证编号',
      'certification_status.required'  => '请您选择认证状态',
      'certification_content.required' => '请您输入认证意见',
    ];

    $rule = [
      'certification_id'      => 'required',
      'certification_status'  => 'required',
      'certification_content' => 'required',
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
        $model = $this->_model::getRow(['id' => $request->certification_id]);

        $model->certification_status  = $request->certification_status;
        $model->certification_content = $request->certification_content ?? '';
        $model->save();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
