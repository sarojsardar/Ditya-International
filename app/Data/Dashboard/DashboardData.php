<?php
namespace App\Data\Dashboard;
use App\Enum\DocumentProcessStatus;
use App\Enum\InvoiceStatus;
use App\Enum\PassportInStatus;
use App\Models\CandidateInvoice;
use App\Models\DocumentProcess;
use App\Models\PassportIn;
use App\Models\PassportOuts;
use Carbon\Carbon;
use App\Models\User;
use App\Enum\UserTypes;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\CancelBills;
use App\Enum\InterviewStatus;
use App\Models\CompanyDemand;
use App\Enum\DocumentCancellationStages;

class DashboardData{

    public function companyCount(){
        return Company::count();
    }

    public function candidateCount(){
        if(auth('web')->user()->hasRole(['Company'])){
            $candidates = auth('web')->user()->companyInfo->candidates;
            return count($candidates);
        }elseif(auth('web')->user()->hasRole(['PRO'])){
            $candidates = auth('web')->user()->candidates;
            return count($candidates);
        }
        else{
            return Candidate::count();
        }
    }

    public function staffCount(){
        return User::whereHas('roles', function($query) {
            return $query->where('name', '!=', 'CEO');
        })->where('user_type', UserTypes::NORMAL)->count();
    }

    public function demandCount(){
        if(auth('web')->user()->hasRole(['Company'])){
            $demands = auth('web')->user()->companyInfo->demandDetail;
            return count($demands);
        }else{
            return CompanyDemand::count();
        }
    }

    public function newRegisteredCandidates(){
        if(auth('web')->user()->hasRole(['Company'])){
            return Candidate::join('company_demands', 'candidates.demand_id', '=', 'company_demands.id')
                ->join('companies', 'company_demands.company_id', '=', 'companies.id')
                ->where('companies.id', '=', auth('web')->user()->companyInfo->id)
                ->orderBy('candidates.created_at', 'desc')->limit(5)->get();
        }elseif(auth('web')->user()->hasRole(['PRO'])){
            return Candidate::where('pro_id', auth('web')->id())->orderBy('created_at', 'desc')->limit(5)->get();   
        }
        else{
            return Candidate::orderBy('created_at', 'desc')->limit(5)->get();
        }
    }

    public function newInterviewCount(){
        if(auth('web')->user()->hasRole(['Company'])){
            return Interview::where('company_id', auth('web')->id())->where('status', InterviewStatus::NEW)->count();
        }else{
            return Interview::where('status', InterviewStatus::NEW)->count();
        }
    }
    public function approvedInterviewCount(){
        if(auth('web')->user()->hasRole(['Company'])){
            return Interview::where('company_id', auth('web')->id())->where('status', InterviewStatus::APPROVED)->count();
        }else{
            return Interview::where('status', InterviewStatus::APPROVED)->count();
        }
    }
    public function rejectedInterviewCount(){
        if(auth('web')->user()->hasRole(['Company'])){
            return Interview::where('company_id', auth('web')->id())->where('status', InterviewStatus::REJECTED)->count();
        }else{
            return Interview::where('status', InterviewStatus::REJECTED)->count();
        }
    }

    public function stageDocumentData(){

        $date = Carbon::today();
        $dates = [];

        for ($i = 0; $i < 30; $i++) {
            $dates[] = $date->copy()->subDays($i);
        }
        $dates = array_reverse($dates);
        $strDates = [];
        $stages = DocumentProcessStatus::getAllValues();
        $allData = [];
        foreach ($dates as $date){
            array_push($strDates, Carbon::parse($date)->format('M d, Y'));
            if(auth('web')->user()->hasRole(['Company'])){
                $totalRegistered =  Candidate::join('company_demands', 'candidates.demand_id', '=', 'company_demands.id')
                ->join('companies', 'company_demands.company_id', '=', 'companies.id')
                ->where('companies.id', '=', auth('web')->user()->companyInfo->id)
                ->whereDay('candidates.created_at', $date)->count();    
            }else{
                $totalRegistered = Candidate::whereDay('created_at', $date)->count();
            }
            foreach ($stages as $key => $stage){
                if($stage != DocumentProcessStatus::SUBMIT && $stage != DocumentProcessStatus::REJECT){
                    if(auth('web')->user()->hasRole(['Company'])){
                        $candidates = Candidate::join('document_processes', 'candidates.id', '=', 'document_processes.candidate_id')
                        ->join('company_demands', 'candidates.demand_id', '=', 'company_demands.id')
                        ->join('companies', 'company_demands.company_id', '=', 'companies.id')
                        ->where('companies.id', '=', auth('web')->user()->companyInfo->id)  
                        ->where('document_processes.document_status', $stage)                  
                        ->whereDay('candidates.created_at', $date)
                        ->count();
                        $data[$key] = $candidates;
                    }else{
                        $candidates = Candidate::join('document_processes', 'candidates.id', '=', 'document_processes.candidate_id')
                        ->whereDay('candidates.created_at', $date)
                        ->where('document_processes.document_status', $stage)
                        ->count();
                        $data[$key] = $candidates;    
                    }
                }
            }
            $data['TOTAL_REGISTERED'] = $totalRegistered;
            array_push($allData, $data);
        }

        return [
            'dates' => $strDates,
            'report' => $allData
        ];
    }


    public function passportInOut(){
        $passportIns = PassportIn::count();
        $passportOuts = PassportOuts::count();
        $totalCandidates = Candidate::count();

        $data['in'] = $passportIns;
        $data['out'] = $passportOuts;
        $data['total'] = $totalCandidates;
        return $data;
    }

    public function newMedicals(){
        if(auth('web')->user()->hasRole(['Company'])){
            $candidates = DocumentProcess::join('candidates', 'document_processes.candidate_id', '=', 'candidates.id')
            ->join('company_demands', 'candidates.demand_id', '=', 'company_demands.id')
            ->join('companies', 'company_demands.company_id', '=', 'companies.id')
            ->where('companies.id', auth('web')->id())
            ->where('document_processes.document_status', DocumentProcessStatus::MEDICAL_NEW)->count();
            return $candidates;
        }elseif(auth('web')->user()->hasRole(['PRO'])){
            $candidates = DocumentProcess::join('candidates', 'document_processes.candidate_id', '=', 'candidates.id')
            ->where('candidates.pro_id', auth('web')->id())
            ->where('document_processes.document_status', DocumentProcessStatus::MEDICAL_NEW)->count();
            return $candidates;
        }
        else{
            $candidates = DocumentProcess::where('document_status', DocumentProcessStatus::MEDICAL_NEW)->count();
            return $candidates;
        }
    }
    public function rejectedCandidates(){
        if(auth('web')->user()->hasRole(['Company'])){
            $candidates = DocumentProcess::join('candidates', 'document_processes.candidate_id', '=', 'candidates.id')
            ->join('company_demands', 'candidates.demand_id', '=', 'company_demands.id')
            ->join('companies', 'company_demands.company_id', '=', 'companies.id')
            ->where('companies.id', auth('web')->id())
            ->where('document_processes.document_status', DocumentProcessStatus::REJECTED)->count();
            return $candidates;
        }elseif(auth('web')->user()->hasRole(['PRO'])){
            $candidates = DocumentProcess::join('candidates', 'document_processes.candidate_id', '=', 'candidates.id')
            ->where('candidates.pro_id', auth('web')->id())
            ->where('document_processes.document_status', DocumentProcessStatus::REJECTED)->count();
            return $candidates;
        }else{
            $candidates = DocumentProcess::where('document_status', DocumentProcessStatus::REJECTED)->count();
            return $candidates;
        }
    }

    public function newInvoices(){
        $invoices = CandidateInvoice::where('payment_status', InvoiceStatus::NEW)->count();
        return $invoices;
    }
    public function partialInvoices(){
        $invoices = CandidateInvoice::where('payment_status', InvoiceStatus::PARTIALL_PAYMENT)->count();
        return $invoices;
    }
    public function paidInvoices(){
        $invoices = CandidateInvoice::where('payment_status', InvoiceStatus::FULLY_PAID)->count();
        return $invoices;
    }
}