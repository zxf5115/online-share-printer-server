<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reset extends Mailable
{
  use Queueable, SerializesModels;

  protected $member = null;

  protected $code = null;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($member, $code)
  {
    $this->member = $member;
    $this->code   = $code;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('emails.reset')
                ->with([
                  'email' => $this->member->email,
                  'code' => $this->code,
                ]);
  }
}
