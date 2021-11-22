<?php
namespace App\Imports\Outbound;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Http\Constant\Code;
use App\Models\Platform\Module\Inventory;
use App\Events\Platform\Inventory\LogEvent;
use App\Models\Platform\Module\Outbound\Detail;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-15
 *
 * 设备导入类
 */
class EquipmentImport implements ToCollection, WithBatchInserts, WithChunkReading
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
          record('花名册缺少内容');

          continue;
        }

        $model = $row[0];
        $code  = $row[1];

        $inventory = Inventory::firstOrNew(['code' => $code]);

        if(empty($inventory->id))
        {
          record('设备不存在');

          continue;
        }

        if(1 != $inventory->inventory_status['value'])
        {
          record('设备不能出库');

          continue;
        }

        // 标记为预出库
        $inventory->inventory_status = 2;
        $inventory->save();

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
