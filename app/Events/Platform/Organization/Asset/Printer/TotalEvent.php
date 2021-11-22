<?php
namespace App\Events\Platform\Organization\Asset\Printer;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 代理商设备数量事件
 */
class TotalEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $member_id = null;
  public $total     = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member_id, $total = 1)
  {
    $this->member_id = $member_id;
    $this->total     = $total;
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
