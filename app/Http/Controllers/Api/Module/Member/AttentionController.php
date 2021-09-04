<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Models\Api\Module\Member;
use App\Events\Common\Push\AuroraEvent;
use App\Events\Api\Member\AttentionEvent;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-11
 *
 * 会员关注控制器类
 */
class AttentionController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\Attention';

  // 排序条件
  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  // 关联对像
  protected $_relevance = [
    'list' => [
      'member',
      'attention'
    ],
    'select' => [
      'member',
      'attention'
    ]
  ];


  /**
   * @api {get} /api/member/attention/list?page={page} 01. 会员关注列表
   * @apiDescription 获取当前会员关注分页列表
   * @apiGroup 22. 会员关注模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {int} page 当前页数
   *
   * @apiSuccess (字段说明|基础) {Number} id 会员关注编号
   * @apiSuccess (字段说明|基础) {Number} member_id 会员编号
   * @apiSuccess (字段说明|基础) {Number} attention_member_id 关注会员编号
   * @apiSuccess (字段说明|基础) {Number} create_time 关注时间
   * @apiSuccess (字段说明|关注人) {Number} avatar 头像
   * @apiSuccess (字段说明|关注人) {Number} nickname 昵称
   * @apiSuccess (字段说明|被关注人) {Number} avatar 头像
   * @apiSuccess (字段说明|被关注人) {Number} nickname 昵称
   *
   * @apiSampleRequest /api/member/attention/list
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

      $response = $this->_model::getPaging($condition, $relevance, $this->_order);

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
   * @api {post} /api/member/attention/status 02. 是否关注会员
   * @apiDescription 获取当前会员是否关注指定会员
   * @apiGroup 22. 会员关注模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {Number} attention_member_id 关注会员编号
   *
   * @apiSuccess (字段说明) {Boolean} status 是否关注
   *
   * @apiSampleRequest /api/member/attention/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    $messages = [
      'attention_member_id.required' => '请您输入关注会员编号',
    ];

    $rule = [
      'attention_member_id' => 'required',
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

        $where = ['attention_member_id' => $request->attention_member_id];

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
   * @api {post} /api/member/attention/handle 03. 关注操作
   * @apiDescription 当前会员执行关注操作, 已经关注过，再次点击取消关注
   * @apiGroup 22. 会员关注模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} attention_member_id 关注编号
   *
   * @apiSampleRequest /api/member/attention/handle
   * @apiVersion 1.0.0
   */
  public function handle(Request $request)
  {
    $messages = [
      'attention_member_id.required' => '请您输入关注编号',
    ];

    $rule = [
      'attention_member_id' => 'required',
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
        $result = Member::getRow(['id' => $request->attention_member_id]);

        if(empty($result->id))
        {
          return self::error(Code::ATTENTION_MEMBER_EMPTY);
        }

        $response = $this->_model::createOrDelete([
          'member_id'           => self::getCurrentId(),
          'attention_member_id' => $request->attention_member_id
        ]);

        // 记录关注总数
        event(new AttentionEvent($response, $request->attention_member_id));

        $nickname = self::getCurrentNickname();

        $content = $nickname . '关注了您';

        $data = [
          'title'     => '关注消息',
          'content'   => $content,
        ];

        // 消息推送
        event(new AuroraEvent(1, $data, $request->attention_member_id));

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
