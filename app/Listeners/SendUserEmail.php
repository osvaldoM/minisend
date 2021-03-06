<?php

namespace App\Listeners;

use App\Events\NewEmailPosted;
use App\Mail\UserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmail implements ShouldQueue
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
    public function handle($event)
    {
        try {
            if($event->email->should_fail){
                throw new \Exception('Should fail param was set to true');
            }
            Mail::to($event->email->message->to)
                ->send(new UserMail($event->email));
        }
        catch (\Exception $e) {
            $event->email->setFailed($e->getMessage());
        }
    }
}
