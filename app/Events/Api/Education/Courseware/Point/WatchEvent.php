<?php
namespace App\Events\Api\Education\Courseware\Point;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 课程知识点浏览事件
 */
class WatchEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $data_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($data_id)
  {
    $this->data_id = $data_id;
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
