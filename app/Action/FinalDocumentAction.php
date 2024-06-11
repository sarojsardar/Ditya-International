<?php
namespace App\Action;

use App\Models\Candidate\ETicketProcess;
use App\Models\Candidate\EVisaProcess;
use App\Models\Candidate\LabourPermit;
use App\Models\CompanyCandidate;
use App\Models\CompanyDemand;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinalDocumentAction
{
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uplodaDocument()
    {
        $candidateIds = json_decode($this->request->all_candidates, true);
        $candidateStatusNotificationAction = new CandidateStatusNotificationAction();
        $fileSupport = new FileSupportAction();
        if($this->request->has('labour_permit')){
            $file = $fileSupport->uploadFile($this->request->labour_permit, 'candidate/document');
            $labourPermitIds = [];
            foreach ($candidateIds as $key => $candidateId) {
                $companyCandidate = CompanyCandidate::where('id', $candidateId)->first();
                $companyDemand = CompanyDemand::where('id', $companyCandidate->demand_id)->first();
                if($companyCandidate){
                    $labourPermit = LabourPermit::create([
                        'user_id'=>$companyCandidate->user_id,
                        'company_id'=>$companyCandidate?->company_id,
                        'demand_id'=>$companyDemand?->id,
                        'demand_code'=>$companyDemand?->demand_code,
                        'status'=>"Successed",
                        'reason'=>null,
                        'permit'=>$file,
                        'is_new'=>true,
                    ]);
                    $labourPermitIds[] = $labourPermit->refresh()->id;
                }
            }
            $candidateStatusNotificationAction->updateLabourPermitStatus($labourPermitIds);
        }




        if($this->request->has('e_visa')){
            $file = $fileSupport->uploadFile($this->request->e_visa, 'candidate/document');
            $evisaIds = [];
            foreach ($candidateIds as $key => $candidateId) {
                $companyCandidate = CompanyCandidate::where('id', $candidateId)->first();
                $companyDemand = CompanyDemand::where('id', $companyCandidate->demand_id)->first();
                if($companyCandidate){
                    $evisa = EVisaProcess::create([
                        'user_id'=>$companyCandidate->user_id,
                        'company_id'=>$companyCandidate?->company_id,
                        'demand_id'=>$companyDemand?->id,
                        'demand_code'=>$companyDemand?->demand_code,
                        'status'=>"Successed",
                        'reason'=>null,
                        'visa'=>$file,
                        'is_new'=>true,
                    ]);
                    $evisaIds[] = $evisa->refresh()->id;
                }
            }
            $candidateStatusNotificationAction->updateEVisaStatus($evisaIds);
        }



        if($this->request->has('eticket')){
            $file = $fileSupport->uploadFile($this->request->eticket, 'candidate/document');
            $eticketIds = [];
            foreach ($candidateIds as $key => $candidateId) {
                $companyCandidate = CompanyCandidate::where('id', $candidateId)->first();
                $companyDemand = CompanyDemand::where('id', $companyCandidate->demand_id)->first();
                if($companyCandidate){
                    $eticket = ETicketProcess::create([
                        'user_id'=>$companyCandidate->user_id,
                        'company_id'=>$companyCandidate?->company_id,
                        'demand_id'=>$companyDemand?->id,
                        'demand_code'=>$companyDemand?->demand_code,
                        'status'=>"Successed",
                        'reason'=>null,
                        'departure_date'=>Carbon::parse($this->request->departure_date),
                        'arrival_date'=>Carbon::parse($this->request->arrivale_date),
                        'eticket'=>$file,
                        'is_new'=>true,
                    ]);
                    $eticketIds[] = $eticket->refresh()->id;
                }
            }
            $candidateStatusNotificationAction->updateETicketStatus($eticketIds);
        }
    }
}