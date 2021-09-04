<?php
namespace App\Events\Api\Member\Information;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 项目收藏事件
 */
class CollectionEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $type = null;
  public $project_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($type, $project_id)
  {
    $this->type       = $type;
    $this->project_id = $project_id;
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
