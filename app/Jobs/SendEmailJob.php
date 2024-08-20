<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $web_content, $email, $title, $from, $from_address, $filepath;
    /**
     * Create a new job instance.
     */
    public function __construct($web_content, $email, $title, $from=null, $from_address=null, $filepath=null)
    {
        $this->web_content = $web_content;
        $this->email = $email;
        $this->title = $title;
        $this->from = $from;
        $this->from_address = $from_address;
        $this->filepath = $filepath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info($this->filepath);
        Mail::to($this->email)->send(new SendMail($this->web_content, $this->title, $this->from, $this->from_address, $this->filepath));
    }
}
