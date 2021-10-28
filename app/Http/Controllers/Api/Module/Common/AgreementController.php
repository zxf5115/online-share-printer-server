<?php
namespace App\Http\Controllers\Api\Module\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Http\Constant\Code;
use App\Http\Constant\RedisKey;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-08
 *
 * 协议控制器类
 */
class AgreementController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\System\Config\Agreement';


  /**
   * @api {get} /api/common/agreement/about 03. 关于我们
   * @apiDescription 获取关于我们协议
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} content 协议内容
   *
   * @apiSampleRequest /api/common/agreement/about
   * @apiVersion 1.0.0
   */
  public function about(Request $request)
  {
    try
    {
      // 平台核心数据Reids Key
      $key = RedisKey::AGREEMENT;

      if(Redis::hexists($key, 'about'))
      {
        $data = Redis::hget($key, 'about');

        $response = unserialize($data);
      }
      else
      {
        $response = $this->_model::getRow(['title' => 'about']);

        $data = serialize($response);

        Redis::hset($key, 'about', $data);
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
   * @api {get} /api/common/agreement/user 04. 用户协议
   * @apiDescription 获取用户协议
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} content 协议内容
   *
   * @apiSampleRequest /api/common/agreement/user
   * @apiVersion 1.0.0
   */
  public function user(Request $request)
  {
    try
    {
      // 平台核心数据Reids Key
      $key = RedisKey::AGREEMENT;

      if(Redis::hexists($key, 'user'))
      {
        $data = Redis::hget($key, 'user');

        $response = unserialize($data);
      }
      else
      {
        $response = $this->_model::getRow(['title' => 'user']);

        $data = serialize($response);

        Redis::hset($key, 'user', $data);
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
   * @api {get} /api/common/agreement/employ 05. 使用协议
   * @apiDescription 获取使用协议
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} content 协议内容
   *
   * @apiSampleRequest /api/common/agreement/employ
   * @apiVersion 1.0.0
   */
  public function employ(Request $request)
  {
    try
    {
      // 平台核心数据Reids Key
      $key = RedisKey::AGREEMENT;

      if(Redis::hexists($key, 'employ'))
      {
        $data = Redis::hget($key, 'employ');

        $response = unserialize($data);
      }
      else
      {
        $response = $this->_model::getRow(['title' => 'employ']);

        $data = serialize($response);

        Redis::hset($key, 'user', $data);
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
   * @api {get} /api/common/agreement/privacy 06. 隐私协议
   * @apiDescription 获取使用协议
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} content 协议内容
   *
   * @apiSampleRequest /api/common/agreement/privacy
   * @apiVersion 1.0.0
   */
  public function privacy(Request $request)
  {
    try
    {
      // 平台核心数据Reids Key
      $key = RedisKey::AGREEMENT;

      if(Redis::hexists($key, 'privacy'))
      {
        $data = Redis::hget($key, 'privacy');

        $response = unserialize($data);
      }
      else
      {
        $response = $this->_model::getRow(['title' => 'privacy']);

        $data = serialize($response);

        Redis::hset($key, 'privacy', $data);
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
   * @api {get} /api/common/agreement/liability 07. 免责声明
   * @apiDescription 获取免责声明
   * @apiGroup 02. 公共模块
   *
   * @apiSuccess (basic params) {String} content 协议内容
   *
   * @apiSampleRequest /api/common/agreement/liability
   * @apiVersion 1.0.0
   */
  public function liability(Request $request)
  {
    try
    {
      // 平台核心数据Reids Key
      $key = RedisKey::AGREEMENT;

      if(Redis::hexists($key, 'liability'))
      {
        $data = Redis::hget($key, 'liability');

        $response = unserialize($data);
      }
      else
      {
        $response = $this->_model::getRow(['title' => 'liability']);

        $data = serialize($response);

        Redis::hset($key, 'liability', $data);
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
