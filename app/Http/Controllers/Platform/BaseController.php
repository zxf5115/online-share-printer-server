<?php
namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\BaseController as Common;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-28
 *
 * 基础接口控制器类
 */
class BaseController extends Common
{
  /**
   * 当前用户
   */
  protected $user = null;

  /**
   * 搜索条件
   */
  protected $_params = [
    'title',
    'username',
    'realname',
  ];

  /**
   * 可查询字段与查询类型
   */
  protected $_filter = [
    // 模糊查询
    'like' => [
      'name',
      'code',
      'title',
      'mobile',
      'nickname',
      'content',
      'username',
      'realname',
      'order_no',
      'weixin',
      'symbol',
      'base_currency',
      'quote_currency',
      'slug',
      'symbol',
      'fullname',
    ],
    // 时间查询
    'time' => [
      'create_time',
      'valid_time',
      'add_time',
      'course_start_time',
    ],
    // 小于查询
    'less' => [],
    // 大于查询
    'greater' => []
  ];


  // 判断是否拥有权限
  public function __construct()
  {
  	// 这里额外注意了：官方文档样例中只除外了『login』
    // 这样的结果是，token 只能在有效期以内进行刷新，过期无法刷新
    // 如果把 refresh 也放进去，token 即使过期但仍在刷新期以内也可刷新
    // 不过刷新一次作废
    // 另外关于上面的中间件，官方文档写的是『auth:api』
    // 但是我推荐用 『jwt.auth』，效果是一样的，但是有更加丰富的报错信息返回
    $this->middleware(['auth:platform', 'refresh.token'], ['except' => ['login', 'kernel', 'check_user_login']]);

    $this->user = auth('platform')->user();
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-12
   * ------------------------------------------
   * 获取列表信息
   * ------------------------------------------
   *
   * 获取列表信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getBaseWhereData();

      $page = $request->limit ?? 10;

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $relevance = self::getRelevanceData($this->_relevance, 'list');

      $response = $this->_model::getPaging($condition, $relevance, $this->_order, false, $page);

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
   * @dateTime 2020-02-12
   * ------------------------------------------
   * 获取列表信息
   * ------------------------------------------
   *
   * 获取列表信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function select(Request $request)
  {
    try
    {
      $condition = self::getBaseWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $relevance = self::getRelevanceData($this->_relevance, 'select');

      $response = $this->_model::getList($condition, $relevance, $this->_order);

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
   * @dateTime 2021-01-05
   * ------------------------------------------
   * 启用（停用）课程类型
   * ------------------------------------------
   *
   * 启用（停用）课程类型
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function status(Request $request)
  {
    try
    {
      $model = $this->_model::find($request->id);

      $field = $request->field;

      $model->$field = $request->value;
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
    try
    {
      $id = json_decode($request->id) ?? [0];

      $response = $this->_model::remove($id);

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
   * @dateTime 2020-03-07
   * ------------------------------------------
   * 获取当前登录用户的机构编号
   * ------------------------------------------
   *
   * 获取当前登录用户的机构编号
   *
   * @return 机构编号
   */
  public static function getOrganizationId()
  {
    try
    {
      return auth('platform')->user()->organization_id ?? 0;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return 0;
    }
  }




  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-20
   * ------------------------------------------
   * 获取当前登录用户的角色编号
   * ------------------------------------------
   *
   * 获取当前登录用户的角色编号
   *
   * @return 角色编号
   */
  public static function getCurrentRoleId()
  {
    try
    {
      return auth('platform')->user()->role_id ?? 0;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return 0;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-03-07
   * ------------------------------------------
   * 获取当前用户编号
   * ------------------------------------------
   *
   * 获取当前用户编号
   *
   * @return 用户编号
   */
  public static function getCurrentId()
  {
    try
    {
      return auth('platform')->user()->id ?? 0;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return 0;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-07-09
   * ------------------------------------------
   * 获取当前用户昵称
   * ------------------------------------------
   *
   * 获取当前用户昵称
   *
   * @return 用户编号
   */
  public static function getCurrentName()
  {
    try
    {
      return auth('platform')->user()->nickname ?? 0;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return 0;
    }
  }
}
