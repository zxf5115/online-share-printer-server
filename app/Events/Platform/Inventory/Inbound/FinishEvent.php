<?php
namespace App\Events\Platform\Inventory\Inbound;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 完成入库事件
 */
class FinishEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $inbound_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($inbound_id)
  {
    $this->inbound_id = $inbound_id;
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
