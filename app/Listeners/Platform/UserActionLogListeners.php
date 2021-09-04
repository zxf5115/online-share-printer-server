<?php
namespace App\Listeners\Platform;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use GeoIp2\Database\Reader;
use Jenssegers\Agent\Agent;
use App\Models\Platform\System\Log\Action;
use App\Events\Platform\UserActionLogEvent;

class UserActionLogListeners
{
  private $_agent = null;

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    $this->_agent = new Agent();
  }

  /**
   * Handle the event.
   *
   * @param  UserActionLogEvent  $event
   * @return void
   */
  public function handle(UserActionLogEvent $event)
  {
    try
    {
      $user_id  = $event->user->id;
      $username = $event->user->nickname;
      $request  = $event->request;

      $url     = $request->url();

      if(false !== strpos($url, 'login'))
      {
        $this->login($user_id, $username, $request);
      }
      else if(false !== strpos($url, 'logout'))
      {
        $this->logout($user_id, $username, $request);
      }
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-23
   * ------------------------------------------
   * 用户登录行为
   * ------------------------------------------
   *
   * 用户登录行为
   *
   * @param [type] $username [description]
   * @param [type] $request [description]
   * @return [type]
   */
  public function login($user_id, $username, $request)
  {
    try
    {
      $current_date = date('Y-m-d H:i:s');

      $log             = new Action();
      $log->user_id    = $user_id;
      $log->username   = $username;
      $log->operation  = '[' . $username . '] 在 ' . $current_date . ' 登录了系统';
      $log->method     = $request->fullUrl();
      $log->params     = '';
      $log->browser    = $this->getBrowser();
      $log->system     = $this->getSystem();
      $log->ip_address = ip2long($request->ip());
      $log->address    = $this->getAddress($request->ip());

      $log->save();
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-23
   * ------------------------------------------
   * 用户退出行为
   * ------------------------------------------
   *
   * 用户退出行为
   *
   * @param [type] $username [description]
   * @param [type] $request [description]
   * @return [type]
   */
  public function logout($user_id, $username, $request)
  {
    try
    {
      $current_date = date('Y-m-d H:i:s');

      $log             = new Action();
      $log->user_id    = $user_id;
      $log->username   = $username;
      $log->operation  = '[' . $username . '] 在 ' . $current_date . ' 退出了系统';
      $log->method     = $request->fullUrl();
      $log->params     = json_encode($request->all());
      $log->browser    = $this->getBrowser();
      $log->system     = $this->getSystem();
      $log->ip_address = ip2long($request->ip());
      $log->address    = $this->getAddress($request->ip());

      $log->save();
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-10
   * ------------------------------------------
   * 获取客户端浏览器
   * ------------------------------------------
   *
   * 获取客户端浏览器
   *
   * @return [type]
   */
  private function getBrowser()
  {
    $browser = $this->_agent->browser();
    $version = $this->_agent->version($browser);

    return $browser . ' ' . $version;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-10
   * ------------------------------------------
   * 获取操作系统
   * ------------------------------------------
   *
   * 获取操作系统
   *
   * @return [type]
   */
  private function getSystem()
  {
    $platform = $this->_agent->platform();
    $version = $this->_agent->version($platform);

    return $platform . ' ' . $version;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-10-10
   * ------------------------------------------
   * 获取物理地址信息
   * ------------------------------------------
   *
   * 获取物理地址信息
   *
   * @return [type]
   */
  private function getAddress($ip_address)
  {
    try
    {
      $key = env('BAIDU_MAP_KEY');

      $content = file_get_contents('http://api.map.baidu.com/location/ip?ip='.$ip_address.'&ak='.$key.'&coor=bd09ll');

      $data = mb_convert_encoding($content,'UTF-8','GBK');

      $data = json_decode($data, true);

      if(!empty($data))
      {
        if($data['status'] === 0)
        {
          $detail = !empty($data['content']['address']) ? $data['content']['address'] : '国外';
        }
        else
        {
          $detail = '未知';
        }
      }

      return $detail;
    }
    catch(\Exception $e)
    {
      record($e);
    }
  }
}
