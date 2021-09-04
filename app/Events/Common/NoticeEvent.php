<?php
namespace App\Events\Common;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 通知事件
 */
class NoticeEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $type = null;
  public $be_member_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($type, $be_member_id = 0)
  {
    $this->type = $type;
    $this->be_member_id = $be_member_id;
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
