<?php

namespace App\Jobs;


use App\Models\SendCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReInterviewSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobileNo;
    protected $date;
    protected $time;
    protected $venue;
    protected $companyName;

    public function __construct($mobileNo, $date, $time, $venue, $companyName)
    {
        $this->mobileNo = $mobileNo;
        $this->date = $date;
        $this->time = $time;
        $this->venue = $venue;
        $this->companyName = $companyName;
    }

    public function handle()
    {
        SendCode::reinterviewSms($this->mobileNo, $this->date, $this->time, $this->venue, $this->companyName);
    }
}
