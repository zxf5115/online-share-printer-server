<?php
namespace App\Events\Platform\Organization;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 生成小程序码事件
 */
class QrcodeEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $member_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member_id)
  {
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
