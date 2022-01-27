<?php
namespace App\Http\Controllers\Platform\Module\Manager;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2022-02-27
 *
 * 店长银行卡控制器类
 */
class BankController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Common\Module\Organization\Bank';


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

      $where = ['member_id' => $id];

      $condition = array_merge($condition, $where);

      $relevance = self::getRelevanceData($this->_relevance, 'view');

      $response = $this->_model::getRow($condition, $relevance);

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
      'member_id.required' => '请您输入代理商编号',
      'company_name.required' => '请您输入公司名称',
      'open_bank_name.required' => '请您输入开户行名称',
      'branch_bank_name.required' => '请您输入支行名称',
      'card_no.required' => '请您输入银行卡号',
    ];

    $rule = [
      'member_id' => 'required',
      'company_name' => 'required',
      'open_bank_name' => 'required',
      'branch_bank_name' => 'required',
      'card_no' => 'required',
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
        $model = $this->_model::firstOrNew(['member_id' => $request->member_id]);

        $model->member_id = $request->member_id;
        $model->company_name = $request->company_name ?? '';
        $model->open_bank_name = $request->open_bank_name ?? '';
        $model->branch_bank_name = $request->branch_bank_name ?? '';
        $model->card_no = $request->card_no ?? '';
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
