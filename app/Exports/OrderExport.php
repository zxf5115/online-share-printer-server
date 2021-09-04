<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-29
 *
 * 订单导出类
 */
class OrderExport implements FromView
{
  protected $data = null;

  /**
   * 初始化
   */
  public function __construct($data)
  {
    $this->data = $data;
  }


  public function view(): View
  {
    return view('/export/order', ['data' => $this->data]);
  }
}
