<?php
namespace App\Events\Platform\Inventory\Outbound;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AutoEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $member_id     = null;
  public $total         = null;
  public $equipment_url = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member_id, $total, $equipment_url = '')
  {
    $this->member_id     = $member_id;
    $this->total         = $total;
    $this->equipment_url = $equipment_url;
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
