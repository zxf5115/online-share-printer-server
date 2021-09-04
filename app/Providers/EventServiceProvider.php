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

        // 发送邮件
        'App\Events\Common\Push\AuroraEvent' => [
            'App\Listeners\Common\Push\AuroraListeners',
        ],

        // 系统通知
        'App\Events\Common\NoticeEvent' => [
            'App\Listeners\Common\NoticeListeners',
        ],

        // 关注
        'App\Events\Api\Member\AttentionEvent' => [
            'App\Listeners\Api\Member\AttentionListeners',
        ],

        // 会员课程
        'App\Events\Api\Member\CoursewareEvent' => [
            'App\Listeners\Api\Member\CoursewareListeners',
        ],

        // 资讯点赞
        'App\Events\Api\Member\Information\ApprovalEvent' => [
            'App\Listeners\Api\Member\Information\ApprovalListeners',
        ],

        // 资讯收藏
        'App\Events\Api\Member\Information\CollectionEvent' => [
            'App\Listeners\Api\Member\Information\CollectionListeners',
        ],

        // 社区点赞
        'App\Events\Api\Member\Community\ApprovalEvent' => [
            'App\Listeners\Api\Member\Community\ApprovalListeners',
        ],

        // 社区收藏
        'App\Events\Api\Member\Community\CollectionEvent' => [
            'App\Listeners\Api\Member\Community\CollectionListeners',
        ],

        // 资产
        'App\Events\Api\Member\AssetEvent' => [
            'App\Listeners\Api\Member\AssetListeners',
        ],

        // 资产流向
        'App\Events\Api\Member\MoneyEvent' => [
            'App\Listeners\Api\Member\MoneyListeners',
        ],

        // 获取分红
        'App\Events\Api\Member\Share\MoneyEvent' => [
            'App\Listeners\Api\Member\Share\MoneyListeners',
        ],

        // 课程知识点点赞
        'App\Events\Api\Member\Courseware\Point\ApprovalEvent' => [
            'App\Listeners\Api\Member\Courseware\Point\ApprovalListeners',
        ],


        // 支付
        'App\Events\Api\Member\PayEvent' => [
            'App\Listeners\Api\Member\PayListeners',
        ],


        // 快讯利益
        'App\Events\Api\Flash\BenefitEvent' => [
            'App\Listeners\Api\Flash\BenefitListeners',
        ],

        // 快讯评论
        'App\Events\Api\Flash\CommentEvent' => [
            'App\Listeners\Api\Flash\CommentListeners',
        ],



        // 资讯浏览
        'App\Events\Api\Information\BrowseEvent' => [
            'App\Listeners\Api\Information\BrowseListeners',
        ],



        // 课程知识点浏览
        'App\Events\Api\Education\Courseware\Point\WatchEvent' => [
            'App\Listeners\Api\Education\Courseware\Point\WatchListeners',
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
