<?php
namespace App\Data\DocumentProcess;

use App\Data\company\CompanyData;
use App\Enum\DocumentProcessStatus;
use App\Enum\QuotaStatus;
use Illuminate\Http\Request;
use App\Enum\InterviewStatus;
use App\Models\DocumentProcess;
use App\Helper\ImageUploadHelper;
use App\Data\CompanyDemand\CompanyDemandData;

class DocumentProcessData {


    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }


    public function findDocument($documentId){
        return  DocumentProcess::where('id',$documentId)->first();
    }

    public function newDocumentProcess($candidateId){
        DocumentProcess::create([
            'candidate_id' => $candidateId,
            'document_status' => DocumentProcessStatus::MEDICAL_NEW
        ]);
    }

    public function updateDocuments($documentId){

        if($this->request->hasFile('qr')){
            $qrFile = $this->request->file('qr');
            $qrfilename = (new ImageUploadHelper())->uploadImage($qrFile, 'public/uploads/candidate-qr', 'qr');
            $document = $this->findDocument($documentId);
            $document->update([
                'qr' => $qrfilename,
                'passport_self' => $this->request->passport_self,
                'document_status' => DocumentProcessStatus::DOCUMENTS_UPLOADED
            ]);    
        }
    }


    public function updateVisaDocument($documentId){
        $visaFilename = [];
        $visaFiles = $this->request->file('visa');
        foreach($visaFiles as $key => $visaFile){
            $filename = (new ImageUploadHelper())->uploadImage($visaFile, 'public/uploads/candidate-visas', $key.'visa');
            array_push($visaFilename, $filename);
        }
        $document = $this->findDocument($documentId);
        $document->update([
            'visa' => implode(',', $visaFilename),
            'document_status' => DocumentProcessStatus::VISA_RECEIVED
        ]);
    }

    public function updateTicketDocument($documentId){
        $ticketFilename = [];
        $ticketFiles = $this->request->file('ticket');
        foreach($ticketFiles as $key => $ticketFile){
            $name = (new ImageUploadHelper())->uploadImage($ticketFile, 'public/uploads/candidate-tickets', $key.'ticket');
            array_push($ticketFilename, $name);
        }

        $document = $this->findDocument($documentId);

        $document->update([
            'ticket' => implode(',', $ticketFilename),
            'flight_date' => $this->request->flight_date,
            'document_status' => DocumentProcessStatus::TICKET_DONE
        ]);

    }

    public function moveToVisaProcess($documentId){
        $document = $this->findDocument($documentId);

        $document->update([
            'document_status' => DocumentProcessStatus::VISA_PROCESS
        ]);

    }

    public function documentFinalApproval($documentId){
        $document = $this->findDocument($documentId);

        $document->update([
            'document_status' => DocumentProcessStatus::FINAL_APPROVAL
        ]);

    }

    public function rejectCandidate($documentId, $stage){
        $document = $this->findDocument($documentId);

        $document->update([
            'document_status' => DocumentProcessStatus::REJECT,
            'cancellation_stage' => $stage
        ]);

    }

    public function checkCandidateTicketStatusOnDemand($demandId){
        $demand = (new CompanyDemandData())->getDemand($demandId);
        $candidates = $demand->candidates;
        $ticketDoneCount = 0;
        foreach($candidates as $can){
            if(@$can->documentProcess->document_status == DocumentProcessStatus::TICKET_DONE){
                $ticketDoneCount = ++$ticketDoneCount;
            }
        }

        if($ticketDoneCount >= intval($demand->quota_value)){
            $demand->update([
                'quota_status' => QuotaStatus::QUOTA_COMPLETE   
            ]);
        }
    }


    public function newMedicalCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && @$row->documentProcess->document_status == DocumentProcessStatus::MEDICAL_NEW){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function medicalPassedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED){
                if($row->documentProcess){
                    if(@$row->documentProcess->document_status != DocumentProcessStatus::MEDICAL_FAILED  && @$row->documentProcess->document_status != DocumentProcessStatus::MEDICAL_NEW){
                        return $row;
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function medicalFailedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && @$row->documentProcess->document_status == DocumentProcessStatus::MEDICAL_FAILED){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }
    public function newMedicalCandidatesViaCompany($companyId){

        $company = (new CompanyData())->getCompany($companyId);
        
        $candidates = collect($company->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && @$row->documentProcess->document_status == DocumentProcessStatus::MEDICAL_NEW){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function medicalPassedCandidatesViaCompany($companyId){

        $company = (new CompanyData())->getCompany($companyId);

        $candidates = collect($company->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED){
                if($row->documentProcess){
                    if(@$row->documentProcess->document_status != DocumentProcessStatus::MEDICAL_FAILED  && @$row->documentProcess->document_status != DocumentProcessStatus::MEDICAL_NEW){
                        return $row;
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function medicalFailedCandidatesViaCompany($companyId){

        $company = (new CompanyData())->getCompany($companyId);

        $candidates = collect($company->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && @$row->documentProcess->document_status == DocumentProcessStatus::MEDICAL_FAILED){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function newApprovedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && @$row->documentProcess->document_status == DocumentProcessStatus::MEDICAL_PASSED || @$row->documentProcess->document_status == DocumentProcessStatus::DOCUMENTS_UPLOADED){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    

    public function documentSubmittedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && @$row->documentProcess->document_status == DocumentProcessStatus::SUBMITTED){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function visaProcessCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && $row->documentProcess->document_status == DocumentProcessStatus::VISA_PROCESS){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function visaReceivedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && $row->documentProcess->document_status == DocumentProcessStatus::VISA_RECEIVED){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function finalApprovedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && $row->documentProcess->document_status == DocumentProcessStatus::FINAL_APPROVAL){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function ticketDoneCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && $row->documentProcess->document_status == DocumentProcessStatus::TICKET_DONE){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function rejectedCandidates($demandId){

        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if($row->interview->status == InterviewStatus::APPROVED && $row->documentProcess->document_status == DocumentProcessStatus::REJECTED){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();

        return $candidates;
    }

    public function countDocuments($demandId){

        $new = $this->newApprovedCandidates($demandId);
        $submission = $this->documentSubmittedCandidates($demandId);
        $visaProcess = $this->visaProcessCandidates($demandId);
        $visaReceived = $this->visaReceivedCandidates($demandId);
        $final = $this->finalApprovedCandidates($demandId);
        $ticket = $this->ticketDoneCandidates($demandId);
        $rejected = $this->rejectedCandidates($demandId);

        $data['new'] = count($new);
        $data['submission'] = count($submission);
        $data['visaProcess'] = count($visaProcess);
        $data['visaReceived'] = count($visaReceived);
        $data['final'] = count($final);
        $data['ticket'] = count($ticket);
        $data['rejected'] = count($rejected);

        return $data;

    }
}


