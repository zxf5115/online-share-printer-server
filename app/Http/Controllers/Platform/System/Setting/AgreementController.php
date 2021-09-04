<?php
namespace App\Http\Controllers\Platform\System\Setting;

use App\Http\Constant\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-13
 *
 * 系统协议控制器类
 */
class AgreementController extends BaseController
{
  protected $_model = 'App\Models\Platform\System\Config\Agreement';

  protected $_where = [];

  protected $_params = [];

  protected $_order = [
    ['key' => 'id', 'value' => 'desc'],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-12
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
      'name.required'  => '请您输入分类名称',
      'title.required'  => '请您输入分类标题'
    ];

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'title' => 'required'
    ], $messages);


    if($validator->fails())
    {
      $error = $validator->getMessageBag()->toArray();
      $error = array_values($error);
      $message = $error[0][0] ?? Code::$message[Code::ERROR];

      return self::message($message);
    }
    else
    {
      $model = $this->_model::firstOrNew(['id' => $request->id]);

      $model->organization_id = self::getOrganizationId();
      $model->name        = $request->name;
      $model->title       = $request->title;
      $model->content     = $request->content;

      $response = $model->save();

      if($response)
      {
        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      else
      {
        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
