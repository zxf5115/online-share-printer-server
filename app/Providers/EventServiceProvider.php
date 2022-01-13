<?php
namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
          'SocialiteProviders\Weixin\WeixinExtendSocialite@handle',
        ],

        // 记录用户行为日志
        'App\Events\Platform\UserActionLogEvent' => [
            'App\Listeners\Platform\UserActionLogListeners',
        ],

        // 发送短信
        'App\Events\Common\Message\SmsEvent' => [
            'App\Listeners\Common\Message\SmsListeners',
        ],

        // 短信验证码
        'App\Events\Common\Sms\CodeEvent' => [
            'App\Listeners\Common\Sms\CodeListeners',
        ],

        // 发送邮件
        'App\Events\Common\Message\EmailEvent' => [
            'App\Listeners\Common\Message\EmailListeners',
        ],

        // 系统通知
        'App\Events\Common\NoticeEvent' => [
            'App\Listeners\Common\NoticeListeners',
        ],

        // 设备绑定代理商
        'App\Events\Platform\Printer\BindEvent' => [
            'App\Listeners\Platform\Printer\BindListeners',
        ],

        // 生成小程序码
        'App\Events\Platform\Organization\QrcodeEvent' => [
            'App\Listeners\Platform\Organization\QrcodeListeners',
        ],

        // 代理商设备数量
        'App\Events\Platform\Organization\Asset\Printer\TotalEvent' => [
            'App\Listeners\Platform\Organization\Asset\Printer\TotalListeners',
        ],

        // 出库日志
        'App\Events\Platform\Inventory\Outbound\LogEvent' => [
            'App\Listeners\Platform\Inventory\Outbound\LogListeners',
        ],

        // 自动创建出库单
        'App\Events\Platform\Inventory\Outbound\AutoEvent' => [
            'App\Listeners\Platform\Inventory\Outbound\AutoListeners',
        ],

        // 完成出库
        'App\Events\Platform\Inventory\Outbound\FinishEvent' => [
            'App\Listeners\Platform\Inventory\Outbound\FinishListeners',
        ],

        // 入库日志
        'App\Events\Platform\Inventory\Inbound\LogEvent' => [
            'App\Listeners\Platform\Inventory\Inbound\LogListeners',
        ],

        // 入库异常记录
        'App\Events\Platform\Inventory\Inbound\AbnormalEvent' => [
            'App\Listeners\Platform\Inventory\Inbound\AbnormalListeners',
        ],

        // 完成入库
        'App\Events\Platform\Inventory\Inbound\FinishEvent' => [
            'App\Listeners\Platform\Inventory\Inbound\FinishListeners',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
