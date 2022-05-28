<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeSend extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $link;
    public function __construct($user,$link)
    {
        $this->user=$user;
        $this->link=$link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Надійшло нове вітання')->view('mail.welcome');
    }
}
