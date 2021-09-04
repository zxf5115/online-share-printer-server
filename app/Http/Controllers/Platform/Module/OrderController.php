<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Constant\Code;
use App\Exports\OrderExport;
use App\Models\Platform\System\Config;
use App\Events\Common\Push\AuroraEvent;
use App\Models\Platform\Module\Order\Log;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-29
 *
 * 订单控制器类
 */
class OrderController extends BaseController
{
  // 模型
  protected $_model = 'App\Models\Platform\Module\Order';

  // 查询条件
  protected $_params = [
    'order_no',
    'pay_status',
    'order_status',
  ];

  // 附加关联查询条件
  protected $_addition = [
    'courseware' => [
      'title',
    ],
    'member' => [
      'username',
    ],
  ];


  // 关联信息
  protected $_relevance = [
    'list' => [
      'courseware',
      'member',
    ],
    'view' => [
      'courseware',
      'member',
      'log',
    ]
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-09
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
      'id.required'     => '请您输入订单编号',
      'remark.required' => '请您输入订单备注',
    ];

    $rule = [
      'id'     => 'required',
      'remark' => 'required',
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
        $model = $this->_model::getRow(['id' => $request->id]);

        $model->remark = $request->remark;
        $model->save();

        $log = new Log();
        $log->order_id  = $request->id;
        $log->user_id   = self::getCurrentId();
        $log->username  = self::getCurrentName();
        $log->content   = '添加了订单备注';
        $log->save();

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
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 取消订单
   * ------------------------------------------
   *
   * 取消订单
   *
   * @param Request $request 请求参数
   * @return [type]
   */
  public function cancel(Request $request)
  {
    $messages = [
      'id.required'  => '请您输入订单编号',
    ];

    $rule = [
      'id' => 'required',
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
        $model = $this->_model::getRow(['id' => $request->id]);

        $model->order_status = 3;
        $model->save();

        $log = new Log();
        $log->order_id  = $request->id;
        $log->user_id   = self::getCurrentId();
        $log->username  = self::getCurrentName();
        $log->content   = '取消订单';
        $log->save();

        $data = [
          'title'     => '订单消息',
          'content'   => '您的订单已取消',
        ];

        // 消息推送
        event(new AuroraEvent(1, $data, $model->member_id));

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
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-12
   * ------------------------------------------
   * 删除信息
   * ------------------------------------------
   *
   * 删除信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function delete(Request $request)
  {
    DB::beginTransaction();

    try
    {
      $id = json_decode($request->id) ?? [0];

      $response = $this->_model::remove($id);

      foreach($id as $item)
      {
        $log = new Log();
        $log->order_id  = $item;
        $log->user_id   = self::getCurrentId();
        $log->username  = self::getCurrentName();
        $log->content   = '删除订单';
        $log->save();
      }

      DB::commit();

      return self::success($response);
    }
    catch(\Exception $e)
    {
      DB::rollback();

      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 导出订单
   * ------------------------------------------
   *
   * 导出订单
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function export(Request $request)
  {
    try
    {
      $condition = self::getBaseWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $relevance = self::getRelevanceData($this->_relevance, 'select');

      $response = $this->_model::getList($condition, $relevance, $this->_order);

      $dir = 'public/';

      $filename = 'excel/'. '订单记录_'.time().'.xlsx';

      Excel::store(new OrderExport($response), $dir . $filename);

      $url = Config::getConfigValue('web_url');

      $url = $url . '/storage/' . $filename;

      return self::success($url);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
