<?php
namespace App\Events\Common\Sms;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 短信验证码对比事件
 */
class CodeEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  // 登录账户
  public $username = null;

  // 待对比验证码
  public $sms_code = null;

  // 验证码类型 1 登录验证码 2 绑定验证码
  public $type = null;

  // 访问类型 接口 平台
  public $auth = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($username, $sms_code, $type = 1, $auth = 'api')
  {
    $this->username = $username;
    $this->sms_code = $sms_code;
    $this->type     = $type;
    $this->auth     = $auth;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new PrivateChannel('channel-name');
  }
}
