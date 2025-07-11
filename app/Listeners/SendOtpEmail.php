<?php

namespace App\Listeners;

use App\Events\OtpRequest;
use App\Mail\OtpEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOtpEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OtpRequest $event): void
    {
       Mail::to($event->user->email)->send(new OtpEmail($event->user->name , $event->user->code));
    }
}
