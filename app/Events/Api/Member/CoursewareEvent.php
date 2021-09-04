<?php
namespace App\Events\Api\Member;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 会员课程事件
 */
class CoursewareEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $member_id = null;

  public $courseware_id = null;

  public $source = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member_id, $courseware_id, $source = 1)
  {
    $this->member_id = $member_id;

    $this->courseware_id = $courseware_id;

    $this->source = $source;
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
