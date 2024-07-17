<?php

namespace App\Jobs;

use App\Mail\NewPostEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $incomingJob;
    /**
     * Create a new job instance.
     */
    public function __construct($incomingJob)
    {
        $this->incomingJob = $incomingJob;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->incomingJob['sendTo'])->send(new NewPostEmail([
            'title' => $this->incomingJob['title'],
            'name' => $this->incomingJob['name']
        ]));
    }
}
