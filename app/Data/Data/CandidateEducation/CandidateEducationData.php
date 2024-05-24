<?php
namespace App\Data\CandidateEducation;

use Illuminate\Http\Request;
use App\Models\CandidateEducation;
use Illuminate\Support\Facades\DB;
use App\Data\Candidate\CandidateData;

class CandidateEducationData{


    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }


    public function store($candidateId){
        $educations = $this->request->education;
        $candidate = (new CandidateData())->findCandidate($candidateId);

        if($candidate->educations->isEmpty()){
            foreach ($educations as $key => $value) {
                CandidateEducation::create([
                    'candidate_id' => $candidateId,
                    'education' => $value
                ]);
            }
        }else{
            DB::table('candidate_education')->where('candidate_id', $candidateId)->delete();
            foreach ($educations as $key => $value) {
                CandidateEducation::create([
                    'candidate_id' => $candidateId,
                    'education' => $value
                ]);
            }
        }
    }
}