<?php

namespace App\Http\Controllers\Document;

use App\Models\User;
use App\Enum\UserTypes;
use App\Models\Company;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Models\EducationType;
use App\Models\CompanyCandidate;
use App\Http\Controllers\Controller;
use App\Models\Candidat\MedicalCheckup;
use App\Data\Datatables\DocumentAccessApidata;
use App\Models\Interview;

class DocumentAccessController extends Controller
{
    public function getInCandidates(Request $request)
    {

        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        if($request->ajax()){
            return (new DocumentAccessApidata($request))->getInCandidates();
        }
        return view('backend.pages.document-officer.in-check', ['companies'=>$companies, 'medicals'=>$medicals]);
    }



    public function showDetails($companyCandidateId)
    {
        $companyCandidate = CompanyCandidate::findOrFail($companyCandidateId)->firstOrFail();
        $userDetails = User::with([
            'userDetail', 
            'educationalQualification', 
            'passportDetail', 
            'workExperience', 
            'languageDetail',
            'uploadPhoto',
            'BankDetail',
            'resumeDetail',
            'categoryDetail'
        ])->where('id', $companyCandidate->user_id)->firstOrFail();

        $medicalCheckup = MedicalCheckup::where([
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
            'user_id'=>$userDetails->id,
        ])->latest()->first();

        $interview = Interview::where([
            'demand_id'=>$companyCandidate->demand_id,
            'user_id'=>$userDetails->id,
        ])->latest()->first();
        // Check if the user was found
        // Find the company candidate by user ID
        $educationTypes = EducationType::all();
        $languages = Language::all();
        $demands = CompanyDemand::get();
        $proUsers = User::role('PRO')->get();
        $companies = Company::get();
        return view('backend.pages.document-officer.view', [
            'userDetails'=>@$userDetails,
            'educationTypes'=>@$educationTypes,
            'languages'=>@$languages,
            'demands'=>@$demands,
            'proUsers'=>@$proUsers,
            'companies'=>@$companies,
            'demandId'=>@$companyCandidate->demand_id,
            'companyCandidate'=>@$companyCandidate,
            'medicalCheckup'=>$medicalCheckup,
            'interview'=>$interview,
        ]);
    }

    public function proceedToVisa(Request $request, $companyCandidateId)
    {
        
    }
    public function sendNotification(Request $request)
    {
        
    }
}
