<?php

namespace App\Jobs;

use App\Models\SendCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile_content, $mobileNo;
    /**
     * Create a new job instance.
     */
    public function __construct($mobile_content, $mobileNo)
    {
        $this->mobile_content = $mobile_content;
        $this->mobileNo = $mobileNo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        SendCode::sendSms($this->mobile_content, $this->mobileNo);
    }
}
