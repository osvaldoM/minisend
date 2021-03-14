<?php

namespace App\Listeners;

use App\Events\NewEmailPosted;
use App\Mail\UserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle(NewEmailPosted $event)
    {
        Mail::to($event->email->message->to)
            ->send(new UserMail($event->email));
    }
}
