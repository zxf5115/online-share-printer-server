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
 * 邮件事件
 */
class EmailEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $member = null;
  public $code  = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member, $code)
  {
    $this->member = $member;
    $this->code   = $code;
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
