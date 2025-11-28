<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $job;
    public $user;

    public function __construct($application)
    {
        $this->application = $application;
        $this->job = $application->job;
        $this->user = $application->user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Selamat! Lamaran Anda Diterima - ' . $this->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application_accepted',
            with: [
                'application' => $this->application,
                'job' => $this->job,
                'user' => $this->user,
            ],
        );
    }
}
