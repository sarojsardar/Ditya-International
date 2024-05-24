<?php

namespace App\Http\Controllers\Backend;

use App\Enum\Language;
use App\Models\Candidate;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enum\EducationLevels;
use App\Enum\LanguageSkillTypes;
use App\Enum\LanguageSkillLevels;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Data\Candidate\CandidateData;

class MasterSearchController extends Controller
{
    
    public function index(){

        $candidates = null;
        $candidate = null;

        $filters = [
            'candidate_id' => null,
            'full_name' => null,
            'contact' => null,
            'pro' => null
        ];

        return view('backend.pages.master-search.index', compact('filters', 'candidate', 'candidates'));
    }

    public function search(Request $request){

        $candidate = null;
        $candidates = null;
        $filters = [
            'candidate_id' => $request->candidate_id,
            'full_name' => $request->full_name,
            'contact' => $request->contact,
            'pro' => $request->pro
        ];

        if(Arr::get($filters, 'candidate_id')){
            $educationalQualifications = EducationLevels::getAllValues();
            $languages = Language::getAllValues();
            $languageSkills = LanguageSkillTypes::getAllValues();
            $languageSkillLevels = LanguageSkillLevels::getAllValues();
            $candidate = (new CandidateData())->findCandidateViaRef(Arr::get($filters, 'candidate_id'));
    
            if(!$candidate){
                $candidate = null;
                return view('backend.pages.master-search.index', compact('filters', 'candidate'))->with('error', 'Candidate record not found having provided ID');
            }

            return view('backend.pages.master-search.index', compact('filters', 'candidate', 'educationalQualifications', 'languages', 'languageSkills', 'languageSkillLevels'));
        }
        

        if(Arr::get($filters, 'full_name') || Arr::get($filters, 'contact') || Arr::get($filters, 'pro')){
            $candidates = Candidate::when(Arr::get($filters, 'contact'), function($q) use ($filters){
                $q->where('contact', 'Like', '%'.Arr::get($filters, 'contact').'%');
            })
            ->when(Arr::get($filters, 'full_name'), function($q1) use ($filters){
                $keywords = explode(' ', Arr::get($filters, 'full_name'));
                foreach ($keywords as $word) {
                    $q1->where('first_name', 'LIKE', '%' . $word . '%')
                        ->orWhere('middle_name', 'LIKE', '%' . $word . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $word . '%');
                }
            })
            ->when(Arr::get($filters, 'pro'), function ($q2) use ($filters){
                $q2->with('pro', function ($q3) use ($filters){
                    $q3->with('userInfo', function($q4) use ($filters){
                        $keywords = explode(' ', Arr::get($filters, 'pro'));
                        foreach ($keywords as $word) {
                            $q4->where('first_name', 'LIKE', '%' . $word . '%')
                                ->orWhere('middle_name', 'LIKE', '%' . $word . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $word . '%');
                        }
                    });
                });
            })
            ->get();

            $candidates = collect($candidates)->map(function($row){
                if($row->pro->userInfo){
                    return $row;
                }else{
                    return null;
                }
            })->whereNotNull();

        }


        return view('backend.pages.master-search.index', compact('filters', 'candidate', 'candidates'));

    }
}
