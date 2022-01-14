<?php
namespace App\Http\Controllers\Platform\System\Config;

use Illuminate\Http\Request;

use App\Http\Constant\Code;
use App\Http\Controllers\Platform\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-08
 *
 * 系统配置分类控制器类
 */
class CategoryController extends BaseController
{
  protected $_model = 'App\Models\Platform\System\Config\Category';

  protected $_where = [
    'status' => 1,
    'parent_id' => 0
  ];

  protected $_params = [
    'parent_id',
    'name'
  ];

  protected $_order = [
    ['key' => 'sort', 'value' => 'desc'],
    ['key' => 'id', 'value' => 'asc']
  ];

  protected $_relevance = [
    'children'
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
      'title.required' => '请您输入分类标题'
    ];

    $rule = [
      'name' => 'required',
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
      $model = $this->_model::firstOrNew(['id' => $request->id]);

      $parent_id = $request->parent_id;

      if(is_array($parent_id))
      {
        $parent_id = array_pop($parent_id) ?: 0;
      }

      $model->organization_id = self::getOrganizationId();
      $model->name        = $request->name;
      $model->title       = $request->title;
      $model->parent_id   = $parent_id;
      $model->content     = $request->content;
      $model->depth       = $request->depth;
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
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-22
   * ------------------------------------------
   * 获取分类分级数据
   * ------------------------------------------
   *
   * 获取分类分级数据
   *
   * @return [type]
   */
  public function level()
  {
    $condition = self::getBaseWhereData();

    $where = ['parent_id' => 0];

    $condition = array_merge($condition, $where);

    $tree = $this->_model::getList($condition, 'children', $this->_order, true);

    return self::success($tree);
  }
}
