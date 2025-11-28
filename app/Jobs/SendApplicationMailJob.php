<?php

namespace App\Jobs;

use App\Mail\JobAppliedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplicationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job;
    public $user;
    public $cvPath;

    public function __construct($job, $user, $cvPath = null)
    {
        $this->job = $job;
        $this->user = $user;
        $this->cvPath = $cvPath;
    }

    public function handle()
    {
        Mail::to($this->user->email)
            ->send(new JobAppliedMail($this->job, $this->user, $this->cvPath));
    }
}
