<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        //
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->email;
        return $this
            ->withSwiftMessage(function ($message) use($email) {
                $message->email = $email;
            })
            ->from($this->email->message->from)
            ->view('emails.email-form')
            ->text('emails.email-form_plain')
            ->with(array_merge(
                $this->email->message->toArray(),
                ['email_id' => $this->email->id]
            ));
    }
}
