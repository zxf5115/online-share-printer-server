<?php
namespace App\Events\Api\Flash;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 快讯利益事件
 */
class BenefitEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $type = null;
  public $flash_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($type, $flash_id)
  {
    $this->type     = $type;
    $this->flash_id = $flash_id;
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
