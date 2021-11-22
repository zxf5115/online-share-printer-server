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

  public $model      = null;
  public $code       = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($model, $code)
  {
    $this->model = $model;
    $this->code  = $code;
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
