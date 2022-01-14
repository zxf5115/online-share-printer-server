<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-16
 *
 * 菜单控制器类
 */
class MenuController extends BaseController
{
  protected $_model = 'App\Models\Platform\System\Menu';

  protected $_where = [];

  protected $_params = [
    'category'
  ];

  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  protected $_relevance = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-26
   * ------------------------------------------
   * 获取菜单tree
   * ------------------------------------------
   *
   * 获取菜单tree
   *
   * @param Request $request [description]
   * @return 菜单tree
   */
  public function list(Request $request)
  {
    try
    {
      $condition = self::getBaseWhereData();

      // 对用户请求进行过滤
      $filter = $this->filter($request->all());

      $condition = array_merge($condition, $this->_where, $filter);

      $response = $this->_model::getList($condition, $this->_relevance, $this->_order);

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
      'title.required'  => '请您输入菜单名称',
    ];

    $rule = [
      'title' => 'required',
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
        $model = $this->_model::firstOrNew(['id' => $request->id]);

        $organization_id = self::getOrganizationId();

        $parent_id = $request->parent_id;

        if(is_array($parent_id))
        {
          $parent_id = array_pop($parent_id) ?: 0;
        }

        $model->organization_id = $organization_id;
        $model->title       = $request->title;
        $model->parent_id   = $parent_id;
        $model->content     = $request->content;
        $model->url         = $request->url;
        $model->category    = $request->category ?: 1;
        $model->type        = $request->type ?: 1;
        $model->icon        = $request->icon;
        $model->is_hidden   = $request->is_hidden;
        $model->sort        = $request->sort;

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
      catch(\Exception $e)
      {
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

      $response = $this->_model::getList($condition, $this->_relevance, false, true);

      $all_menu_id = array_column($response, 'id');

      $result = [
        'menu' => $response,
        'all_menu_id' => $all_menu_id
      ];

      return self::success($result);
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
   * @dateTime 2020-09-20
   * ------------------------------------------
   * 获取分级菜单信息
   * ------------------------------------------
   *
   * 获取分级菜单信息
   *
   * @return [type]
   */
  public function level()
  {
    try
    {
      $condition = self::getBaseWhereData();

      $where = ['parent_id' => 0];

      $condition = array_merge($condition, $where);

      $tree = $this->_model::getList($condition, 'children', $this->_order, true);

      return self::success($tree);
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
   * @dateTime 2021-01-23
   * ------------------------------------------
   * 获取菜单的面包屑
   * ------------------------------------------
   *
   * 根据传递过来的URL获取菜单的面包屑
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function track(Request $request)
  {
    try
    {
      $url = ltrim($request->url, '/');

      $bread = [];

      $where = ['url' => $url];

      $result = $this->_model::getRow($where);

      if(empty($result))
      {
        $bread[] = '控制台';

        return self::success($bread);
      }

      $bread[] = $result['title'];

      if($result['parent_id'] > 0)
      {
        $where = [
          'id' => $result['parent_id']
        ];

        $result = $this->_model::getRow($where);

        $bread[] = $result['title'];
      }

      $bread = array_reverse($bread);

      return self::success($bread);
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
   * @dateTime 2021-01-23
   * ------------------------------------------
   * 获取当前选中菜单
   * ------------------------------------------
   *
   * 根据传递过来的URL获取当前选中菜单
   *
   * @param Request $request [description]
   * @return [type]
   */
  public function active(Request $request)
  {
    try
    {
      $response = 0;

      $url = ltrim($request->url, '/');

      $where = ['url' => $url];

      $result = $this->_model::getRow($where);

      if(!empty($result))
      {
        $response = $result->id;
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
}
