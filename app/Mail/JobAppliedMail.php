<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class JobAppliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $user;
    public $cvUrl;

    public function __construct($job, $user, $cvPath = null)
    {
        $this->job = $job;
        $this->user = $user;
        // Generate URL untuk download CV
        $this->cvUrl = $cvPath ? Storage::url($cvPath) : null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lamaran Baru untuk ' . $this->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job_applied',
            with: [
                'job' => $this->job,
                'user' => $this->user,
                'cvUrl' => $this->cvUrl,
            ],
        );
    }
}
