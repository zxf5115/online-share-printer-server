<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
  <title>经销商电子授权书</title>
</head>

<body>
  <div class="ctn">
    <h1>《共享打印》</h1>
    <h2>经销商电子授权书</h2>
    <p class="top">
      兹授权：<br/>
      <span>{{ $data['nickname'] ?? '' }}</span> <br/>
      为共享打印业务在<span>{{ $data['archive']['province_id']['text'] ?? '' }} {{ $data['archive']['city_id']['text'] ?? '' }} {{ $data['archive']['region_id']['text'] ?? '' }}</span>的合格代理商，级别为{{ $data['level']['text'] ?? '一级代理商' }}，有权开展共享打印业务，并提供相关的售后服务。
    </p>
    <div class="bottom">
      <table>
        <tr>
          <td>
            <div class="left">
              <h3 style="margin-top: 10px;">经销商信息：</h3>
              <p style="margin-top: 47px;">
                姓名：<span>{{ $data['nickname'] }}</span><br/>
                性别：<span>女</span><br/>
                所在地：<span>{{ $data['archive']['address'] ?? '' }}</span><br/>
                手机号：<span>{{ $data['username'] }}</span><br/>
                微信号：<span>{{ $data['archive']['weixin'] ?? '' }}</span><br/>
                邮箱：<span>{{ $data['archive']['email'] ?? '' }}</span><br/>
                上级分销商电话：<span>{{ $data['parent']['username'] ?? '' }}</span><br/>
                设备数量：<span>{{ $data['asset']['should_printer_total'] ?? '' }}</span><br/>
                授权号：<span>1241092401924</span><br/>
              </p>
            </div>
          </td>
          <td>
           <div class="right">
            <h3 style="margin-top: 77px;text-align: center;">授权码</h3>
            <img src="{{ $data['archive']['register_qrcode_url'] ?? '' }}" alt="">
            <label style="margin: 55px 0 0 20px;">扫描二维码下载共享打印代理端</label>
          </div>
        </td>
      </tr>
    </table>
    </div>
    <div class="footer">
      <p class="desc">授权单位：三友映画科技发展有限公司</p>
      <div class="auth">
        <img id="image0" width="240" height="242"
    src="https://img2.baidu.com/it/u=2656539769,2055516863&fm=253&fmt=auto&app=138&f=JPG?w=408&h=409">
      </div>
    </div>
  </div>
</body>
</html>

<style type="text/css">
  * {
    margin: 0;
    padding: 0;
  }
  body {
    height: calc(2105px - 130px);
    width: calc(1487px - 130px);
    background-color: white;
    padding: 2px;
    font-family: PingFang SC;
  }
  .ctn {
    position: relative;
    width: 100%;
    height: 100%;
    border: 1px black solid;
  }
  .ctn::after {
    content: '';
    position: absolute;
    width: calc(100% - 22px);
    height: calc(100% - 22px);
    border: 1px black solid;
    z-index: 1;
    left: 11px;
    top: 11px;
  }
  h1 {
    font-size: 60px;
    width: 100%;
    text-align: center;
    margin-top: 77px;
  }
  h2 {
    font-size: 24px;
    width: 100%;
    text-align: center;
    margin-top: 10px;
    font-weight: 500;
  }
  h3 {
    font-size: 24px;
    width: 100%;
    font-weight: 500;
  }
  p span {
    text-decoration:underline
  }
  .top {
    padding-bottom: 37px;
    border-bottom: 1px solid black;
    width: calc(100% - 180px);
    margin: 0 40px;
    margin-top: 32px;
  }
  p {
    color: black;
    font-size: 24px;
    font-weight: 400;
    line-height: 200%;
  }
  .bottom {
    display: flex;
    justify-content: space-between;
    align-items: start;
    width: calc(100% - 180px);
    margin: 0 40px;
  }
  .bottom .left {
    width: calc(100% - 304px);
    display: flex;
    flex-direction: column;
  }
  .bottom .right {
    width: 304px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 0 210px 200px;
  }
  .bottom .right img {
    width: 300px;
    margin-top: 27px;
  }
  label {
    font-size: 18px;
    /* font-weight: bold; */
  }
  .desc {
    position: absolute;
    text-align: center;
    width: 100%;
    bottom: 25px;
    z-index: 2;
  }
  .auth {
    position: absolute;
    width: 240px;
    height: 242px;
    right: 97px;
    bottom: 25px;
    z-index: 1;
  }
  .footer{
      margin-top: 160px;
  }
</style>
