<?php
namespace App\Http\Controllers\Api\Module\Member\Flash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Events\Api\Flash\BenefitEvent;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员快讯利益控制器类
 */
class BenefitController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Flash\Benefit';


  /**
   * @api {post} /api/member/flash/benefit/status 01. 快讯利益态度
   * @apiDescription 当前会员是否发表快讯利益态度
   * @apiGroup 54. 会员快讯利益模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (basic params) {Number} flash_id 快讯编号
   *
   * @apiSampleRequest /api/member/flash/benefit/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    $messages = [
      'flash_id.required' => '请您输入快讯编号',
    ];

    $rule = [
      'flash_id' => 'required',
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
        $status = true;

        $condition = self::getCurrentWhereData();

        $where = ['flash_id' => $request->flash_id];

        $condition = array_merge($condition, $where);

        $response = $this->_model::getRow($condition);

        return self::success($response);
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        self::record($e);

        return self::error(Code::ERROR);
      }
    }
  }



  /**
   * @api {get} /api/member/flash/benefit/bullish 02. 会员利多操作
   * @apiDescription 当前会员会员快讯利多操作
   * @apiGroup 54. 会员快讯利益模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} flash_id 快讯编号
   *
   * @apiSampleRequest /api/member/flash/benefit/bullish
   * @apiVersion 1.0.0
   */
  public function bullish(Request $request)
  {
    $messages = [
      'flash_id.required' => '请您输入快讯编号',
    ];

    $rule = [
      'flash_id' => 'required',
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
        $model = $this->_model::firstOrNew([
          'member_id' => self::getCurrentId(),
          'flash_id' => $request->flash_id
        ]);

        $model->feel_status = 1;
        $model->save();

        // 利多
        event(new BenefitEvent(1, $request->flash_id));

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @api {get} /api/member/flash/benefit/bearish 03. 会员利空操作
   * @apiDescription 当前会员会员快讯利空操作
   * @apiGroup 54. 会员快讯利益模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} flash_id 快讯编号
   *
   * @apiSampleRequest /api/member/flash/benefit/bearish
   * @apiVersion 1.0.0
   */
  public function bearish(Request $request)
  {
    $messages = [
      'flash_id.required' => '请您输入快讯编号',
    ];

    $rule = [
      'flash_id' => 'required',
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
        $model = $this->_model::firstOrNew([
          'member_id' => self::getCurrentId(),
          'flash_id' => $request->flash_id
        ]);

        $model->feel_status = 2;
        $model->save();

        // 利空
        event(new BenefitEvent(2, $request->flash_id));

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }
}
