<?php
namespace App\Events\Platform\Organization;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 生成小程序码事件
 */
class QrcodeEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $invite_code = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($invite_code)
  {
    $this->invite_code = $invite_code;
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
