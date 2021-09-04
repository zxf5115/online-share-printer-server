<?php
namespace App\Http\Controllers\Platform\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Http\Constant\Code;
use App\Http\Constant\RedisKey;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Platform\BaseController;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-09
 *
 * 系统控制器类
 */
class SystemController extends BaseController
{
  protected $_model = 'App\Models\Platform\System\Config';

  protected $_where = [
    'category_id' => 1
  ];

  protected $_params = [];

  protected $_order = [
    ['key' => 'create_time', 'value' => 'desc'],
  ];

  protected $_relevance = [];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-12
   * ------------------------------------------
   * 系统核心配置信息
   * ------------------------------------------
   *
   * 系统核心配置信息
   *
   * @param Request $request [请求参数]
   * @return [type]
   */
  public function kernel()
  {
    try
    {
      // 平台核心数据Reids Key
      $key = RedisKey::KERNEL;

      if(Redis::exists($key))
      {
        $data = Redis::get($key);

        $response = unserialize($data);
      }
      else
      {
        $condition = self::getBaseWhereData();

        $condition = array_merge($condition, $this->_where);

        $response = $this->_model::where($condition)->pluck('value', 'title');

        $data = serialize($response);

        Redis::set($key, $data);
      }

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-20
   * ------------------------------------------
   * 清空所有缓存
   * ------------------------------------------
   *
   * 清空所有缓存
   *
   * @return [type]
   */
  public function clear()
  {
    try
    {
      Cache::flush();

      // 清除Redis中平台核心信息
      Redis::del(RedisKey::KERNEL);

      // 清除Redis中协议信息
      Redis::del(RedisKey::AGREEMENT);

      // 清除Redis中平台菜单信息
      Redis::del(RedisKey::PLATFORM_MENU);

      return self::success();
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::CLEAR_FAILURE);
    }
  }
}
