<?php
namespace App\Http\Controllers\Api\Module\Member\Currency;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Models\Api\Module\Currency\Symbol;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-13
 *
 * 会员自选货币控制器类
 */
class OptionalController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Currency\Optional';

  // 排序
  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];


  /**
   * @api {get} /api/member/currency/optional/list?page={page} 01. 自选货币列表
   * @apiDescription 获取当前自选货币分页列表
   * @apiGroup 83. 自选货币模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|货币交易对) {Number} id 货币编号
   * @apiSuccess (字段说明|货币交易对) {String} symbol 交易对
   * @apiSuccess (字段说明|货币交易对) {String} base_currency 交易对中的基础币种
   * @apiSuccess (字段说明|货币交易对) {String} quote_currency 交易对中的报价币种
   * @apiSuccess (字段说明|货币交易对) {String} state 交易对状态
   * @apiSuccess (字段说明|会员) {Number} avatar 会员头像
   * @apiSuccess (字段说明|会员) {Number} nickname 会员昵称
   *
   * @apiSampleRequest /api/member/currency/optional/list
   * @apiVersion 1.0.0
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getCurrentWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      // 获取关联对象
      $relevance = self::getRelevanceData($this->_relevance, 'list');

      $symbol_id = $this->_model::getPluck('symbol_id', $condition, false, false, true);

      $condition = self::getSimpleWhereData();

      $where = [
        ['id', $symbol_id]
      ];

      $condition = array_merge($condition, $where);

      $response = Symbol::getPaging($condition, $relevance, $this->_order, true);

      $data = $response['data'] ?? '';

      if(!empty($data))
      {
        $symbol = array_column($data, 'symbol');

        $symbol = implode(',', $symbol);

        $result = Symbol::getData($symbol);

        if(is_array($result))
        {
          foreach($response['data'] as $key => &$item)
          {
            $item['api'] = $result[$key];
          }
        }
      }

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
   * @api {post} /api/member/currency/optional/status 02. 是否加入自选
   * @apiDescription 获取当前自选货币的详情
   * @apiGroup 83. 自选货币模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (basic params) {Number} symbol_id 货币交易对编号
   *
   * @apiSampleRequest /api/member/currency/optional/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    $messages = [
      'symbol_id.required' => '请您输入货币交易对编号',
    ];

    $rule = [
      'symbol_id' => 'required',
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

        $where = ['symbol_id' => $request->symbol_id];

        $condition = array_merge($condition, $where);

        $response = $this->_model::getRow($condition);

        if(empty($response->id))
        {
          $status = false;
        }

        return self::success($status);
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
   * @api {post} /api/member/currency/optional/handle 03. 加入货币自选
   * @apiDescription 当前会员执行加入自选作, 已经加入过，再次点击取消加入
   * @apiGroup 83. 自选货币模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} symbol_id 货币交易对编号
   *
   * @apiSampleRequest /api/member/currency/optional/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'symbol_id.required' => '请您输入货币交易对编号',
    ];

    $rule = [
      'symbol_id' => 'required',
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
        $status = $this->_model::createOrDelete([
          'member_id' => self::getCurrentId(),
          'symbol_id' => $request->symbol_id
        ]);

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
