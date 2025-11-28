<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class NewApplicationNotification extends Notification
{
    use Queueable;

    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // menambahkan 'database'
    }

    // method untuk email
    public function toMail($notifiable)
    {
        $cvUrl = url(Storage::url($this->application->cv));

        return (new MailMessage)
            ->subject('Lamaran Baru Diterima - ' . $this->application->job->title)
            ->greeting('Halo Admin!')
            ->line('Ada lamaran baru yang masuk untuk posisi:')
            ->line('**Posisi:** ' . $this->application->job->title)
            ->line('**Pelamar:** ' . $this->application->user->name)
            ->line('**Email:** ' . $this->application->user->email)
            ->line('**Tanggal:** ' . $this->application->created_at->format('d F Y, H:i') . ' WIB')
            ->action('📄 Download CV', $cvUrl)
            ->action('👀 Lihat Semua Lamaran', url('/applications'))
            ->line('Silakan review lamaran ini segera.')
            ->salutation('Terima kasih!');
    }

    // method untuk database notification
    public function toDatabase($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job->title,
            'user_id' => $this->application->user_id,
            'user_name' => $this->application->user->name,
            'user_email' => $this->application->user->email,
            'cv_path' => $this->application->cv,
            'message' => 'Lamaran baru untuk posisi ' . $this->application->job->title . ' dari ' . $this->application->user->name,
            'created_at' => $this->application->created_at->format('d F Y, H:i'),
        ];
    }

    // representasi array
    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'user_name' => $this->application->user->name,
        ];
    }
}
