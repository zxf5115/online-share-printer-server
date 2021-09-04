<?php
namespace App\Events\Api\Member\Courseware\Point;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 课程知识点点赞事件
 */
class ApprovalEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $status = null;
  public $data_id = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($status, $data_id)
  {
    $this->status  = $status;
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
