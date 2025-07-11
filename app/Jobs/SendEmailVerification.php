<?php

namespace App\Jobs;

use App\Events\OtpRequest;
use App\Mail\OtpEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification implements ShouldQueue
{
    use Queueable;

    public $user ;
    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user ;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Sending email to: " . $this->user->email);
        Mail::to($this->user->email)->send(new OtpEmail($this->user->name , $this->user->code));
//        event(OtpRequest::dispatch($this->user));
    }
}
