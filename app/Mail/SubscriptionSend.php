<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionSend extends Mailable
{
    use Queueable, SerializesModels;

    public $words;
    public $anecdotes;
    public $url;
    public function __construct($words,$anecdotes)
    {
        $this->words=$words;
        $this->anecdotes=$anecdotes;
        $this->url=env('APP_URL');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->subject(env('APP_NAME').' Розсилка ')->view('mail.subscription_send');
        return $this->subject('Нові приколи, розсилка')->view('mail.subscription_send');
    }
}
