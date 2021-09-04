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
 * 金额流向事件
 */
class MoneyEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $member_id = null;
  public $money     = null;
  public $type      = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($member_id, $money, $type = 1)
  {
    $this->member_id = $member_id;
    $this->money     = $money;
    $this->type      = $type;
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
