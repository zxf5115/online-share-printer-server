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
 * 入库异常事件
 */
class AbnormalEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $inbound_id = null;
  public $member_id  = null;
  public $type       = null;
  public $model      = null;
  public $code       = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($inbound_id, $member_id, $type, $model, $code)
  {
    $this->inbound_id = $inbound_id;
    $this->member_id  = $member_id;
    $this->type       = $type;
    $this->model      = $model;
    $this->code       = $code;
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
