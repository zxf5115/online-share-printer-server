<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Models\Platform\System\Config;
use App\Models\Platform\System\Config\Agreement;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-09
 *
 * 系统配置控制器类
 */
class SettingController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Platform\System\Config';

  // 客户端搜索字段
  protected $_params = [
    'category_id',
  ];

  // 排序方式
  protected $_order = [
    ['key' => 'id', 'value' => 'asc'],
  ];

  // 关联对象
  protected $_relevance = [
    'category'
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-09
   * ------------------------------------------
   * 系统配置
   * ------------------------------------------
   *
   * 网站配置信息
   *
   * @param Request $request 请求数据
   * @return [type]
   */
  public function data(Request $request)
  {
    try
    {
      $response = Config::change($request->all());

      if($response)
      {
        return self::success();
      }

      return self::error(Code::HANDLE_FAILURE);
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
   * @dateTime 2020-02-12
   * ------------------------------------------
   * 协议操作
   * ------------------------------------------
   *
   * 协议操作
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function agreement(Request $request)
  {
    if($request->isMethod('post'))
    {
      $messages = [
        'name.required'  => '请您输入配置名称',
      ];

      $rule = [
        'name' => 'required'
      ];

      // 验证用户数据内容是否正确
      $validation = self::validation($request, $messages, $rule);

      if(!$validation['status'])
      {
        return $validation['message'];
      }
      else
      {
        $model = Agreement::getRow(['title' => $request->type]);

        $model->name    = $request->name;
        $model->content = $request->content;

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
    else
    {
      $response = Agreement::getRow(['title' => $request->type]);

      return self::success($response);
    }
  }
}
