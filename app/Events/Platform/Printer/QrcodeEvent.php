<?php
namespace App\Events\Platform\Printer;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 设备二维码事件
 */
class QrcodeEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $printer_id = null;
  public $params = null;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($printer_id, $params)
  {
    $this->printer_id = $printer_id;
    $this->params = $params;
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
