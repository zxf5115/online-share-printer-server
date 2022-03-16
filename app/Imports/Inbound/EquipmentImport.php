<?php
namespace App\Imports\Inbound;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Http\Constant\Code;
use App\Models\Platform\Module\Inventory;
use App\Models\Platform\Module\Inbound\Log;
use App\Models\Platform\Module\Inbound\Detail;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-11-15
 *
 * 设备导入类
 */
class EquipmentImport implements ToCollection, WithBatchInserts, WithChunkReading
{
  protected $inbound_id = null;
  protected $member_id  = null;


  public function __construct($inbound_id, $member_id = 0)
  {
    $this->inbound_id = $inbound_id;
    $this->member_id  = $member_id;
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
        if(empty($row[0]))
        {
          Log::gather($this->inbound_id, '', '', '设备列表内容不完整');

          continue;
        }

        $model = $row[0];
        $code  = $row[1];

        $where = [
          'code' => $code,
          'inventory_status' => 1,
          'status' => 1
        ];

        // 获取库存信息
        $inventory = Inventory::firstOrNew($where);

        if(!empty($inventory->id))
        {
          Log::gather($this->inbound_id, $model, $code, '设备已存在');

          continue;
        }

        $detail = new Detail();

        $detail->inbound_id = $this->inbound_id;
        $detail->member_id  = $this->member_id;
        $detail->model      = $model;
        $detail->code       = $code;
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
