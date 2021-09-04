<?php
namespace App\Events\Common\Message;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * 短信事件
 */
class SmsEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $type   = null;
  public $mobile = null;
  public $code   = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($mobile, $type)
  {
    $this->type   = $type;
    $this->mobile = $mobile;
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
