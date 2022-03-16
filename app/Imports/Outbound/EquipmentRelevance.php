<?php
namespace App\Imports\Outbound;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Http\Constant\Code;
use App\Models\Platform\Module\Printer;
use App\Models\Platform\Module\Outbound;
use App\Models\Platform\Module\Inventory;
use App\Models\Platform\Module\Organization;
use App\Models\Platform\Module\Outbound\Log;
use App\Models\Platform\Module\Outbound\Detail;
use App\Events\Platform\Inventory\Outbound\LogEvent;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-15
 *
 * 设备关联类
 */
class EquipmentRelevance implements ToCollection, WithBatchInserts, WithChunkReading
{
  protected $outbound_id = null;
  protected $member_id   = null;


  public function __construct($outbound_id, $member_id)
  {
    $this->outbound_id = $outbound_id;
    $this->member_id   = $member_id;
  }


  public function collection(Collection $rows)
  {
    //如果需要去除表头
    unset($rows[0]);

    //$rows 是数组格式
    return $this->createData($rows);
  }


  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function createData($rows)
  {
    try
    {
      foreach ($rows as $row)
      {
        if(empty($row[1]))
        {
          Log::gather($this->outbound_id, '', '', '设备列表内容不完整');

          continue;
        }

        $model = $row[0];
        $code  = $row[1];

        // 获取代理商信息
        $organization = Organization::getRow(['id' => $this->member_id, 'status' => 1]);

        if(empty($organization->id))
        {
          Log::gather($this->outbound_id, $model, $code, '代理商不存在');

          continue;
        }

        if(empty($organization->parent_id))
        {
          Log::gather($this->outbound_id, $model, $code, '上级代理商不存在');

          continue;
        }

        $where = [
          ['status', '>', -1],
          'code' => $code,
          'first_level_agent_id' => $organization->parent_id
        ];

        $printer = Printer::getRow($where);

        if(empty($printer->id))
        {
          Log::gather($this->outbound_id, $model, $code, '设备不存在');

          continue;
        }

        if(!empty($printer->second_level_agent_id))
        {
          Log::gather($this->outbound_id, $model, $code, '设备已分配');

          continue;
        }

        $inventory = Inventory::firstOrNew(['code' => $code, 'status' => 1]);

        if(empty($inventory->id))
        {
          Log::gather($this->outbound_id, $model, $code, '设备不存在');

          continue;
        }

        // 出库日志
        event(new LogEvent($inventory->id, $this->member_id, $code, 2));

        // 添加出库记录
        $detail = new Detail();
        $detail->outbound_id = $this->outbound_id;
        $detail->member_id   = $this->member_id;
        $detail->model       = $model;
        $detail->code        = $code;
        $detail->save();
      }

      return true;
    }
    catch(\Exception $e)
    {
      Log::gather($this->outbound_id, $model, $code, '导入异常');

      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-15
   * ------------------------------------------
   * 批量导入1000条
   * ------------------------------------------
   *
   * 多余1000条数据，一次只导入1000条，多次导入
   *
   * @return [type]
   */
  public function batchSize(): int
  {
      return 1000;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-11-15
   * ------------------------------------------
   * 以1000条数据基准切割数据
   * ------------------------------------------
   *
   * 以1000条数据基准切割数据
   *
   * @return [type]
   */
  public function chunkSize(): int
  {
      return 1000;
  }
}
