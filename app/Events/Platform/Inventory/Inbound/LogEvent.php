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
 * 库存日志事件
 */
class LogEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $inventory_id = null; // 库存编号
  public $member_id    = null; // 代理商编号
  public $status       = null; // 日志状态 2 预处理 3 已完成
  public $type         = null; // 日志类型  入库1 出库2

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($inventory_id, $member_id, $status = 2, $type = 1)
  {
    $this->inventory_id = $inventory_id;
    $this->member_id    = $member_id;
    $this->status       = $status;
    $this->type         = $type;
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
