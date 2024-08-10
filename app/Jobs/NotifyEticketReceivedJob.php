<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyDemand;
use Illuminate\Bus\Queueable;
use App\Action\NotificationAction;
use Illuminate\Queue\SerializesModels;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\ETicketProcess;
use App\Models\Candidate\LabourPermit;
use App\Models\Candidate\VisaProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyEticketReceivedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $eTicketIds;
    /**
     * Create a new job instance.
     */
    public function __construct($eTicketIds)
    {
        $this->eTicketIds = $eTicketIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $companyIds = [];
        foreach($this->eTicketIds ?? [] as $eticketID){
            $eticket = ETicketProcess::find($eticketID);
            $receiver = User::find($eticket->user_id);
            $company = Company::find($eticket->company_id);
            $companyIds[] = $company->id;
            if($receiver){
                $go_to_url = '#';
                $demand = CompanyDemand::find($eticket->demand_id);
                $title = "Ticket Received";
                $web_content = 'Your  application has been Ticket Received from '.$company->name.' for demand '. $demand->demand_code.' <a href="'.@$go_to_url.'">View More</a>';
                $mobile_content = 'Your  application has been Ticket Received from '.$company->name.' for demand '. $demand->demand_code.' <a href="'.@$go_to_url.'">View More</a>';
                $generated_by = "System";
                $generated_id = null;
                $generated_to = get_class($receiver);
                $generated_to_id = $receiver->id;
                $send_to = 4;
                try {
                    (new NotificationAction(
                        $title,
                        $web_content,
                        $mobile_content,
                        true,
                        $generated_by,
                        $generated_id,
                        $generated_to,
                        $generated_to_id,
                        $send_to,
                        ))->pushNotification();
                } catch (\Throwable $th) {
                    info("Error : ".$th->getMessage());
                }
            }
        }
    }
}
