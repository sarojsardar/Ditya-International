<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyDemand;
use Illuminate\Bus\Queueable;
use App\Action\NotificationAction;
use Illuminate\Queue\SerializesModels;
use App\Models\Candidat\MedicalCheckup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyMoveToMedicalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $medicalCheckupIds;
    /**
     * Create a new job instance.
     */
    public function __construct($medicalCheckupIds)
    {
        $this->medicalCheckupIds = $medicalCheckupIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->medicalCheckupIds ?? [] as $checkupId){
            $medicalCheckup = MedicalCheckup::find($checkupId);
            $receiver = User::find($medicalCheckup->user_id);
            if($receiver){
                $company = Company::find($medicalCheckup->company_id);
                $go_to_url = '#';
                $demand = CompanyDemand::find($medicalCheckup->demand_id);
                $title = "Medical Checkup Scheduled";
                $web_content = 'Your Medical Checkup Date has been scheduled at '. \Carbon\Carbon::parse($medicalCheckup->checkup_date)->format('Y-m-d H:i').' For the demand '. $medicalCheckup->demand_code .' By '.$company->name .'<a href="'.@$go_to_url.'">View More</a>';
                $mobile_content = 'Your Medical Checkup Date has been scheduled at '. \Carbon\Carbon::parse($medicalCheckup->checkup_date)->format('Y-m-d H:i').' For the demand '. $medicalCheckup->demand_code .' By '.$company->name .'<a href="'.@$go_to_url.'">View More</a>';
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
