<?php
namespace App\Listeners\Common\Push;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Modules\Jpush\JpushService;
use App\Events\Common\Push\AuroraEvent;
use App\Models\Common\Module\Member\Setting;

/**
 * 极光消息推送监听器
 */
class AuroraListeners
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  AuroraEvent  $event
   * @return void
   */
  public function handle(AuroraEvent $event)
  {
    try
    {
      // 推送消息类型
      $type   = $event->type;
      // 推送数据
      $data   = $event->data;
      // 推送人别名
      $member_id = $event->member_id;

      // 获取用户推送设置信息
      $setting= Setting::getRow(['member_id' => $member_id]);

      if(empty($setting->id) || 2 == $setting->push_switch['value'])
      {
        return false;
      }

      // 私信消息
      if(1 == $type)
      {
        $this->message($data, $member_id);
      }
      // 公告消息
      else if(3 == $type)
      {
        $this->notice($data);
      }
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-02
   * ------------------------------------------
   * 极光推送公告消息
   * ------------------------------------------
   *
   * 极光推送公告消息
   *
   * @param [type] $data 推送数据
   * @return [type]
   */
  protected function notice($data)
  {
    try
    {
      // 推送平台 ios android
      $params['platform'] = 'all';
      // 推送标题
      $params['title'] = $data['title'] ?? '币码翁消息';
      // 推送内容
      $params['content'] = $data['content'] ?? '';
      // 通知栏样式 ID
      $params['builderId'] = 1;
      // 附加字段（这里自定义 Key / value 信息，以供业务使用）
      $params['extras'] = $data['data'] ?? [];
      // 推送类型 1-别名 2-注册id 3-全部
      $params['type'] = 3;

      // 开始推送
      $response = JpushService::androidOrIosPushByAlias($params);

      return $response;
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-08-02
   * ------------------------------------------
   * 极光推送私信消息
   * ------------------------------------------
   *
   * 极光推送私信消息
   *
   * @param [type] $data 推送数据
   * @param [type] $member_id 推送人编号
   * @return [type]
   */
  protected function message($data, $member_id)
  {
    try
    {
      // 推送平台 ios android
      $params['platform'] = 'all';
      // 推送标题
      $params['title'] = $data['title'] ?? '币码翁消息';
      // 推送内容
      $params['content'] = $data['content'] ?? '';
      // 通知栏样式 ID
      $params['builderId'] = 1;
      // 附加字段（这里自定义 Key / value 信息，以供业务使用）
      $params['extras'] = $data['data'] ?? [];
      // 推送类型 1-别名 2-注册id 3-全部
      $params['type'] = 1;
      // 别名
      $params['alias'] = strval($member_id);

      // 开始推送
      $response = JpushService::androidOrIosPushByAlias($params);

      return $response;
    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
