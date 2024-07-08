<?php

namespace App\Action;

use App\Enum\DocumentRequirementEnum;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Enum\UserDemandStatus;
use App\Models\CompanyCandidate;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\DocumentProcess;
use App\Models\UserInformation;

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
                $this->title = "You Have Wishlisted By the ".$company->name;
                $this->web_content = 'Congratulation you are in wishlist by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->mobile_content = 'Congratulation you are in wishlist by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->pushNotification();
                break;
            case UserDemandStatus::Rejected:
                $this->title = "Sorry! You Have Rejected By the ".$company->name;
                $this->web_content = 'Sorry! You have rejected by the company  '.$company->name. '. You may notify by our system is any selection for you, you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->mobile_content = 'Sorry! You have rejected by the company  '.$company->name. '. You may notify by our system is any selection for you, you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->pushNotification();
                break;
            case UserDemandStatus::Selected:
                $this->title = "You Have Selected By the ".$company->name;
                $this->web_content = 'Congratulation You have selected by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->mobile_content = 'Congratulation You have selected by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$this->go_to_url.'">View More</a>';
                $this->pushNotification();
                break;
            default:
                # code...
                break;
        }
    }

    private function pushNotification()
    {
        try {
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
        } catch (\Throwable $th) {
            info("Error : ".$th->getMessage());
        }
    }
    public function moveToMedical($medicalCheckupIds)
    {
         // Notification must be developed
    }
    public function updateMedicalCheckupStatus(MedicalCheckup $medicalCheckup)
    {
         // Notification must be developed
    }
    public function proceedToVisa($visaProcessId)
    {
        // Notification must be developed
    }


    public function proceedToEVisa($visaProcessId)
    {
        // Notification must be developed
    }

    public function sendRequiredDocumentNotification(Request $request, CompanyCandidate $companyCandidate)
    {
        $element_ids = $request->element_ids;
        $notified_content = [];
        foreach ($element_ids as $key => $element_id) {
            $data = [
                'element'=>$element_id,
                'reason'=>$request->reasons[$element_id],
            ];
            $notified_content[] = $data;
        }
        $documentProcess = DocumentProcess::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->first();
        
        if($documentProcess){
            $documentProcess->is_notified = true;
            $documentProcess->notified_date = Carbon::now();
            $documentProcess->notified_content = json_encode($notified_content);
            $documentProcess->save();

            $generated_by = "System";
            $generated_id = 0;
            $candidate = User::where('id', $companyCandidate->user_id)->first();
            $candidateInfo = UserInformation::where('user_id', $candidate->id)->first();
            $candidateName = $candidate->email;
            if($candidateInfo){
                $candidateName = $candidateInfo->first_name.' '.$candidateInfo->middle_name.' '.$candidateInfo->last_name;
            }
            // This may be change according to the candidate model 
            $generated_to = get_class($candidate);
            $generated_to_id = $candidate->id ?? 0;
            $title = "Document Requirement";
            $go_to_url = "#";
            // in the below the href must be changed;
            $web_content = "Dear ".$candidateName." <br /> Your Are Receiving the email Due the The Document Requirement, Please Contact, Or Fill au an provide the following document";
            foreach ($notified_content as $key => $notified) {
                $document = DocumentRequirementEnum::getSingleValue($notified['element']);
                $web_content .= "
                    <p style='padding:0; margin:0'>
                        Document: ". $document."
                    </p>
                ";
                $web_content .= "
                    <p style='padding:0; margin:0'>
                        Reason: ". $notified['reason']."
                    </p>
                ";
            }
            $mobile_content = "Dear ".$candidateName."\n Your Are Receiving the email Due the The Document Requirement, Please Contact, Or Fill au an provide the following document";
            foreach ($notified_content as $key => $notified) {
                $document = DocumentRequirementEnum::getSingleValue($notified['element']);
                $web_content .= "Document: ". $document;
                $web_content .= "\nReason: ". $notified['reason'];
            }
            $is_auto = true;
            $send_to = 4;
            (new NotificationAction(
                $title,
                $web_content,
                $mobile_content,
                $is_auto,
                $generated_by,
                $generated_id,
                $generated_to,
                $generated_to_id,
                $send_to,
                $go_to_url,
                'document_requirement',
                $documentProcess->id,
                ))->pushNotification();
        }

        // Notification must be developed
    }



    public function updateVisaStatus($processIds, $visaType="Proceed")
    {
        // Notification must be developed
    }


    public function updateLabourPermitStatus($labourPermitIds)
    {

    }

    public function updateEVisaStatus($eVisaIds)
    {

    }


    public function updateETicketStatus($eTicketIds)
    {

    }

    public function updateCancelledNotification(CompanyCandidate $companyCandidate)
    {
        
    }
}
