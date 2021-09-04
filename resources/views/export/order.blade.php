<table>
  <thead>
  </thead>
  <tbody>
    <tr>
      <td width="20" height='25' style="text-align: center;vertical-align: center;"><b>订单号</b></td>
      <td width="30" height='25' style="text-align: center;vertical-align: center;"><b>课程名称</b></td>
      <td width="15" height='25' style="text-align: center;vertical-align: center;"><b>购买用户</b></td>
      <td width="20" height='25' style="text-align: center;vertical-align: center;"><b>购买账户</b></td>
      <td width="15" height='25' style="text-align: center;vertical-align: center;"><b>实付金额(元)</b></td>
      <td width="15" height='25' style="text-align: center;vertical-align: center;"><b>支付类型</b></td>
      <td width="15" height='25' style="text-align: center;vertical-align: center;"><b>支付状态</b></td>
      <td width="15" height='25' style="text-align: center;vertical-align: center;"><b>订单状态</b></td>
      <td width="30" height='25' style="text-align: center;vertical-align: center;"><b>支付时间</b></td>
    </tr>

    @foreach($data as $k => $item)
      <tr>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['order_no'] ?? '' }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          @if(!empty($item['courseware']))
            @foreach($item['courseware'] as $k => $courseware)
              {{ $courseware['title'] }}
              @if($k < (count($item['courseware']) - 1))
                <br/>
              @endif
            @endforeach
          @endif
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['member']['nickname'] ?? '' }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['member']['username'] ?? '' }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['pay_money'] ?? '' }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['pay_type']['text'] }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['pay_status']['text'] }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['order_status']['text'] }}
        </td>
        <td height='25' style="text-align: center;vertical-align: center;">
          {{ $item['create_time'] }}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
