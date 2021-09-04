<?php
namespace App\Listeners\Common\Message;

use App\Events\Common\Message\EmailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Mail;
use App\Mail\Reset;

class EmailListeners
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {

  }

  /**
   * Handle the event.
   *
   * @param  EmailEvent  $event
   * @return void
   */
  public function handle(EmailEvent $event)
  {
    $member = $event->member;
    $code   = $event->code;

    Mail::to($member->email)->send(new Reset($member, $code));
  }
}
