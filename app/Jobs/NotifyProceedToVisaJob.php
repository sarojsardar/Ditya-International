<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyDemand;
use Illuminate\Bus\Queueable;
use App\Action\NotificationAction;
use Illuminate\Queue\SerializesModels;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\VisaProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyProceedToVisaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $visaProcessId, $type;
    /**
     * Create a new job instance.
     */
    public function __construct($visaProcessId, $type)
    {
        $this->visaProcessId = $visaProcessId;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $companyIds = [];
        foreach($this->visaProcessId ?? [] as $visaId){
            $visaProcess = VisaProcess::find($visaId);
            $receiver = User::find($visaProcess->user_id);
            $company = Company::find($visaProcess->company_id);
            $companyIds[] = $company->id;
            if($receiver){
                $go_to_url = '#';
                $demand = CompanyDemand::find($visaProcess->demand_id);
                $title = "Proceed To ".$this->type;
                $web_content = 'Your Application has been sent for the functher '.$this->type.' Process To '.$company->name.' for demand '. $demand->demand_code.' <a href="'.@$go_to_url.'">View More</a>';
                $mobile_content = 'Your Application has been sent for the functher '.$this->type.' Process To '.$company->name.' for demand '. $demand->demand_code.' <a href="'.@$go_to_url.'">View More</a>';
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
        // to send to the company
        $this->sendToCompany($companyIds);
    }

    public function sendToCompany($companyIds)
    {
        $companyIds = array_unique($companyIds);
        foreach ($companyIds as $key => $companyId) {
           $company = Company::find($companyId);
           if($company){
                $user = User::find($company->user_id);
                if($user){
                    $go_to_url = '#';
                    $title = $this->type." Process Received";
                    $web_content = 'You have received application for the further '.$this->type.' process <a href="'.@$go_to_url.'">View More</a>';
                    $mobile_content = 'You have received application for the further '.$this->type.' process <a href="'.@$go_to_url.'">View More</a>';
                    $generated_by = "System";
                    $generated_id = null;
                    $generated_to = get_class($user);
                    $generated_to_id = $user->id;
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
}
