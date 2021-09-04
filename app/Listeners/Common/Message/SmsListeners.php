<?php
namespace App\Listeners\Common\Message;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Http\Constant\RedisKey;
use App\Events\Common\Message\SmsEvent;

/**
 * 短信消息监听器
 */
class SmsListeners
{
  // 验证码
  private $_code = null;

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  SmsEvent  $event
   * @return void
   */
  public function handle(SmsEvent $event)
  {
    try
    {
      // 待发送手机号码
      $mobile = $event->mobile;

      // 验证码类型
      $type   = $event->type;

      // 生成验证码
      $this->generate($mobile, $type);

      // 登录验证码
      if(1 == $type)
      {
        $this->code($mobile, $this->_code);
      }
      // 注册验证码
      else if(2 == $type)
      {
        $this->registere($mobile, $this->_code);
      }
      // 找回密码验证码
      else if(3 == $type)
      {
        $this->reset($mobile, $this->_code);
      }
      // 更换账户验证码
      else if(4 == $type)
      {
        $this->change($mobile, $this->_code);
      }
      // 绑定账户验证码
      else if(5 == $type)
      {
        $this->bind($mobile, $this->_code);
      }
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-29
   * ------------------------------------------
   * 获取登录验证码
   * ------------------------------------------
   *
   * 获取登录验证码
   *
   * @param [type] $mobile 手机号码
   * @param [type] $code 验证码
   * @return [type]
   */
  protected function code($mobile, $code)
  {
    try
    {
      $content = '您当前登录验证码为: ' . $code . ', 10分钟内容有效。';

      $this->send($mobile, $content);
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-29
   * ------------------------------------------
   * 获取注册验证码
   * ------------------------------------------
   *
   * 获取注册验证码
   *
   * @param    $mobile 手机号码
   * @param [type] $code 验证码
   * @return [type]
   */
  protected function registere($mobile, $code)
  {
    try
    {
      $content = '您当前登录验证码为: ' . $code . ', 10分钟内容有效。';

      $this->send($mobile, $content);
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-29
   * ------------------------------------------
   * 获取重置密码验证码
   * ------------------------------------------
   *
   * 获取重置密码验证码
   *
   * @param    $mobile 手机号码
   * @param [type] $code 验证码
   * @return [type]
   */
  protected function reset($mobile, $code)
  {
    try
    {
      $content = '您当前登录验证码为: ' . $code . ', 10分钟内容有效。';

      $this->send($mobile, $content);
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-29
   * ------------------------------------------
   * 获取更换账户验证码
   * ------------------------------------------
   *
   * 获取更换账户验证码
   *
   * @param    $mobile 手机号码
   * @param [type] $code 验证码
   * @return [type]
   */
  protected function change($mobile, $code)
  {
    try
    {
      $content = '您当前登录验证码为: ' . $code . ', 10分钟内容有效。';

      $this->send($mobile, $content);
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-21
   * ------------------------------------------
   * 获取绑定账户验证码
   * ------------------------------------------
   *
   * 获取绑定账户验证码
   *
   * @param String $mobile 手机号码
   * @param String $code 验证码
   * @return [type]
   */
  protected function bind($mobile, $code)
  {
    try
    {
      $content = '您当前登录验证码为: ' . $code . ', 10分钟内容有效。';

      $this->send($mobile, $content);
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-21
   * ------------------------------------------
   * 生成验证码
   * ------------------------------------------
   *
   * 生成验证码并保存到redis（10分钟自动失效）
   *
   * @param [type] $username 待发送手机号码
   * @param [type] $type 验证码类型
   * @return [type]
   */
  protected function generate($username, $type)
  {
    try
    {
      if(1 == $type)
      {
        $key = RedisKey::SMS_LOGIN_CODE . '_' . $username;
      }
      else if(2 == $type)
      {
        $key = RedisKey::SMS_REGISTERR_CODE . '_' . $username;
      }
      else if(3 == $type)
      {
        $key = RedisKey::SMS_RESET_CODE . '_' . $username;
      }
      else if(4 == $type)
      {
        $key = RedisKey::SMS_CHANGE_CODE . '_' . $username;
      }
      else if(5 == $type)
      {
        $key = RedisKey::SMS_BIND_CODE . '_' . $username;
      }

      // 删除之前的验证码
      if(Redis::exists($key))
      {
        Redis::del($key);
      }

      // 生成6位验证码，不足左侧补0
      $this->_code = str_pad(rand(1, 999999), 6, 0, STR_PAD_LEFT);

      // 记录验证码
      Redis::set($key, $this->_code);

      // 设置验证码时间为10分钟
      Redis::expire($key, 600);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-06-29
   * ------------------------------------------
   * 函数功能简述
   * ------------------------------------------
   *
   * 具体描述一些细节
   *
   * @param [type] $mobile 要发送电话号码
   * @param [type] $content 发送内容
   * @return [type]
   */
  public function send($mobile, $content)
  {
    try
    {
      $url = 'http://m.5c.com.cn/api/send/index.php';

      $data = [
        'apikey'       => getenv('SMS_APIKEY'),
        'username'     => getenv('SMS_USERNAME'),
        'password_md5' => md5(getenv('SMS_PASSWORD')),
        'type'         => 'send',
        'encode'       => 'UTF-8',
        'mobile'       => '86' . $mobile,
        'content'      => urlencode($content),
      ];

      $http = new Client();

      $response = $http->post($url, ['form_params' => $data]);

      if(200 == $response->getStatusCode())
      {
        return true;
      }
      else
      {
        record($response->getBody()->getContents());
      }
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
