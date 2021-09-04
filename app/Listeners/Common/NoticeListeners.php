<?php
namespace App\Listeners\Common;

use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Common\NoticeEvent;
use App\Models\Common\Module\Notice;
use App\Models\Common\Module\Member;
use App\Models\Common\Module\Member\MemberNotice;

/**
 * 通知监听器
 */
class NoticeListeners
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
   * @param  NoticeEvent  $event
   * @return void
   */
  public function handle(NoticeEvent $event)
  {
    try
    {
      // 待处理会员编号
      $be_member_id = $event->be_member_id;

      // 验证码类型
      $type   = $event->type;

      // 系统通知
      if(1 == $type)
      {
        $this->system($be_member_id);
      }
      // 回复我的
      else if(2 == $type)
      {
        $this->reply($be_member_id);
      }
      // 赞过我的
      else if(3 == $type)
      {
        $this->approval($be_member_id);
      }
      // 关注我的
      else if(4 == $type)
      {
        $this->attention($be_member_id);
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
   * @dateTime 2021-06-13
   * ------------------------------------------
   * 系统通知
   * ------------------------------------------
   *
   * 系统通知
   *
   * @param [type] $be_member_id 待处理会员编号
   * @return [type]
   */
  protected function system($be_member_id)
  {
    try
    {

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
   * @dateTime 2021-06-13
   * ------------------------------------------
   * 回复我的
   * ------------------------------------------
   *
   * 回复我的
   *
   * @param [type] $be_member_id 待处理会员编号
   * @return [type]
   */
  protected function reply($be_member_id)
  {
    try
    {

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
   * @dateTime 2021-06-13
   * ------------------------------------------
   * 点赞我的
   * ------------------------------------------
   *
   * 点赞我的
   *
   * @param [type] $be_member_id 待处理会员编号
   * @return [type]
   */
  protected function approval($be_member_id)
  {
    try
    {

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
   * @dateTime 2021-06-13
   * ------------------------------------------
   * 关注我的
   * ------------------------------------------
   *
   * 关注我的
   *
   * @param [type] $be_member_id 待处理会员编号
   * @return [type]
   */
  protected function attention($be_member_id)
  {
    try
    {

    }
    catch (\Exception $e)
    {
      // 记录异常信息
      record($e);

      return false;
    }
  }
}
