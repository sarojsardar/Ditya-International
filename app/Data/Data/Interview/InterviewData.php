<?php
namespace App\Data\Interview;
use App\Data\CompanyDemand\CompanyDemandData;
use App\Enum\InterviewStatus;
use App\Models\Candidate;
use App\Models\Interview;


class InterviewData{

    protected $request;

    public function __construct($request = null){
        $this->request = $request;
    }

    public function store($candidateId, $companyId, $demand_id){

        Interview::create([
            'company_id' => $companyId,
            'demand_id' => $demand_id,
            'candidate_id' => $candidateId,
            'status' => InterviewStatus::NEW
        ]);
    }

    public function newInterviewCandidateList($demandId){
        return Candidate::join('interviews', 'candidates.id', '=', 'interviews.candidate_id')->where('interviews.demand_id', $demandId)->where('interviews.status', '=', InterviewStatus::NEW)->select('candidates.*')->get();
    }

    public function interviewApprovedCandidateList($demandId){
        return Candidate::join('interviews', 'candidates.id', '=', 'interviews.candidate_id')->select('candidates.*', 'interviews.updated_at as updated')->where('interviews.demand_id', $demandId)->where('interviews.status', '=', InterviewStatus::APPROVED)->get();
    }

    public function interviewRejectedCandidateList($demandId){
        return Candidate::join('interviews', 'candidates.id', '=', 'interviews.candidate_id')->select('candidates.*', 'interviews.updated_at as updated')->where('interviews.demand_id', $demandId)->where('interviews.status', '=', InterviewStatus::REJECTED)->get();
    }

    public function countInterviewRecord($demandId){
        $new = Candidate::join('interviews', 'candidates.id', '=', 'interviews.candidate_id')->where('interviews.demand_id', $demandId)->where('interviews.status', '=', InterviewStatus::NEW)->count();
        $approved = Candidate::join('interviews', 'candidates.id', '=', 'interviews.candidate_id')->where('interviews.demand_id', $demandId)->where('interviews.status', '=', InterviewStatus::APPROVED)->count();
        $rejected = Candidate::join('interviews', 'candidates.id', '=', 'interviews.candidate_id')->where('interviews.demand_id', $demandId)->where('interviews.status', '=', InterviewStatus::REJECTED)->count();

        $data['new'] = $new;
        $data['approved'] = $approved;
        $data['rejected'] = $rejected;

        return $data;
    }

    public function approvedCandidatesOnDemand($demand_id){
        return Interview::where('demand_id', $demand_id)->where('status', InterviewStatus::APPROVED)->get();
    }

    public function interviewApprovedCandidateOnDemand($demand_id, $candidates){
        return Interview::where('demand_id', $demand_id)->whereIn('candidate_id', $candidates)->where('status', InterviewStatus::APPROVED)->get();
    }

    public function interviewApprovedAndNewMedical($demandId){
        $demand = (new CompanyDemandData())->getDemand($demandId);
        $candidates = $demand->candidates;

        return collect($candidates)->map(function($row){
            if(@$row->documentProcess){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
    }

    public function proCandidatesMedicalForwardedOnDemand($demandId, $proId){
        $demand = (new CompanyDemandData())->getDemand($demandId);
        $candidates = $demand->candidates;

        return collect($candidates)->map(function($row) use ($proId) {
            if($row->pro_id == $proId){
                if(@$row->documentProcess){
                    return $row;
                }else{
                    return null;
                }
            }else{
                return null;
            }
            
        })->whereNotNull();
    }

}