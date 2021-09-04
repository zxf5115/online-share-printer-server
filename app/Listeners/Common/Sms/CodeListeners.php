<?php
namespace App\Listeners\Common\Sms;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Http\Constant\RedisKey;
use App\Events\Common\Sms\CodeEvent;
use Illuminate\Support\Facades\Redis;

/**
 * 短信验证码对比监听器
 */
class CodeListeners
{
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
   * @param  CodeEvent  $event
   * @return void
   */
  public function handle(CodeEvent $event)
  {
    try
    {
      // 登录账户
      $username = $event->username;

      // 待对比验证码
      $sms_code = $event->sms_code;

      // 验证码类型 1 登录 2 注册 3 重置 4 修改 5 绑定
      $type = $event->type;

      // 访问类型 接口 平台
      $auth = $event->auth;

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

      // 获取真实验证码
      $real_sms_code = Redis::get($key);

      // 如果真实验证码不存在
      if(empty($real_sms_code))
      {
        return false;
      }

      // 验证码错误
      if($real_sms_code != $sms_code)
      {
        return false;
      }

      // Redis::del($key);

      return true;
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
