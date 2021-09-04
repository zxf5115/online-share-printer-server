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
 * 作品评论事件
 */
class CommentEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $flash_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($production_id)
  {
    $this->production_id = $production_id;
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
