<?php

namespace App\Action;

use App\Models\User;
use App\Models\Company;
use App\Enum\UserDemandStatus;
use App\Models\Candidat\MedicalCheckup;

class CandidateStatusNotificationAction
{

    protected 
    $title,
    $web_content,
    $mobile_content,
    $is_auto,
    $generated_by,
    $generated_id,
    $generated_to,
    $generated_to_id,
    $send_to,
    $go_to_url;
    function __construct()
    {
    }


    public function updateStatus($status, $userId)
    {
        $this->send_to = 4;
        $candidate = User::findOrFail($userId);
        $this->generated_by = get_class(auth()->user());
        $this->generated_id = auth()->user()->id;
        $this->go_to_url = "#";
        // This may be change according to the candidate model 
        $generated_to = get_class($candidate);
        $generated_to_id = $candidate->id;
        $company = Company::where('user_id', auth()->user()->id)->latest()->first();
        switch ($status) {
            case UserDemandStatus::Approved:
                $title = "You Have Wishlisted By the ".$company->name;
                $web_content = 'Congratulation you are in wishlist by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $mobile_content = 'Congratulation you are in wishlist by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->pushNotification();
                break;
            case UserDemandStatus::Rejected:
                $title = "Sorry! You Have Rejected By the ".$company->name;
                $web_content = 'Sorry! You have rejected by the company  '.$company->name. '. You may notify by our system is any selection for you, you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $mobile_content = 'Sorry! You have rejected by the company  '.$company->name. '. You may notify by our system is any selection for you, you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->pushNotification();
                break;
            case UserDemandStatus::Selected:
                $title = "You Have Selected By the ".$company->name;
                $web_content = 'Congratulation You have selected by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $mobile_content = 'Congratulation You have selected by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->pushNotification();
                break;
            default:
                # code...
                break;
        }
    }

    private function pushNotification()
    {

        // try {
            (new NotificationAction(
                $this->title,
                $this->web_content,
                $this->mobile_content,
                $this->is_auto,
                $this->generated_by,
                $this->generated_id,
                $this->generated_to,
                $this->generated_to_id,
                $this->send_to,
                $this->go_to_url,
                ))->pushNotification();
        // } catch (\Throwable $th) {
        //     info("Error : ".$th->getMessage());
        // }
    }

    public function moveToMedical($medicalCheckupIds)
    {
        
    }

    public function updateMedicalCheckupStatus(MedicalCheckup $medicalCheckup)
    {

    }
}
