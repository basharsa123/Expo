<?php

namespace App\Jobs;

use App\Mail\LectureQr;
use App\Models\lecture;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class lectureRegistrationQr implements ShouldQueue
{
    use Queueable;
    protected $user;
    protected $lecture;
    protected $qrImage;
    /**
     * Create a new job instance.
     */
    public function __construct( User $user , Lecture $lecture, $qrImage)
    {
        $this->user = $user;
        $this->lecture = $lecture;
        $this->qrImage = $qrImage;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // the queue is work
        Log::info("the lecture email for registration qr is sent");
        //?send email with the qr
        Mail::to($this->user->email)->send(new LectureQr($this->user , $this->lecture , $this->qrImage));
    }
}
