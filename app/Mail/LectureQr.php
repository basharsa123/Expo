<?php

namespace App\Mail;

use App\Models\lecture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LectureQr extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $lecture;
    protected $qrImage;

    /**
     * Create a new message instance.
     */
    public function __construct($user , $lecture , $qrImage )
    {
        $this->user = $user;
        $this->lecture = $lecture;
        $this->qrImage = $qrImage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lecture Registration greeting and Qr For enter',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.lectureRegistrationQr',
            with: ["user" => $this->user , "lecture" => $this->lecture, "qrImage"=>$this->qrImage]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
