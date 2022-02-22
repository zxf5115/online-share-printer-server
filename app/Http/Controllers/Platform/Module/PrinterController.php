<?php
namespace App\Http\Controllers\Platform\Module;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\TraitClass\ToolTrait;
use App\Events\Platform\Printer\QrcodeEvent;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-09-04
 *
 * 打印机控制器类
 */
class PrinterController extends BaseController
{
  use ToolTrait;

  // 模型名称
  protected $_model = 'App\Models\Common\Module\Printer';

  // 客户端搜索字段
  protected $_params = [
    'title',
    'bind_status',
    'activate_status',
  ];

  // 或者查询字段
  // protected $_orwhere = [
  //   'allot_status' => 2
  // ];

  // 关联对象
  protected $_relevance = [
    'list' => [
      'first',
      'second',
      'manager',
    ],
    'select' => false,
    'view' => [
      'manager'
    ],
    'data' => [
      'first',
      'manager.asset'
    ]
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
  public function data(Request $request, $id)
  {
    try
    {
      $condition = self::getBaseWhereData();

      $where = ['id' => $id];

      $condition = array_merge($condition, $where);

      $relevance = self::getRelevanceData($this->_relevance, 'data');

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
   * @dateTime 2021-09-04
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
      'printer_id.required' => '请您输入打印机编号',
    ];

    $rule = [
      'printer_id' => 'required',
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
        $model = $this->_model::getRow(['id' => $request->printer_id]);

        $data = [
          'first_level_agent_id' => self::encrypt($model->first_level_agent_id),
          'second_level_agent_id' => self::encrypt($model->second_level_agent_id),
          'manager_id' => self::encrypt($model->manager_id),
          'printer_id' => self::encrypt($model->id),
        ];

        $params = http_build_query($data);

        event(new QrcodeEvent($model->id, $params));

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        // 记录异常信息
        record($e);

        return self::error(Code::ERROR);
      }
    }
  }
}
