<?php
namespace App\Events\Common\Push;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 极光消息衰推送事件
 */
class AuroraEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $type      = 3;
  public $data      = [];
  public $member_id = 0;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($type, $data, $member_id = 0)
  {
    $this->type      = $type;
    $this->data      = $data;
    $this->member_id = $member_id;
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
