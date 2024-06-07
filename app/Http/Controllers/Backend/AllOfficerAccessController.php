<?php

namespace App\Http\Controllers\Backend;

use App\Action\CandidateStatusNotificationAction;
use App\Data\Datatables\AllOfficerAccessApidata;
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
use App\Models\Candidate\DocumentProcess;
use App\Models\Candidate\VisaProcess;
use App\Models\Interview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AllOfficerAccessController extends Controller
{
    
    public function getCandidates(Request $request)
    {
        if((int)auth()->user()->user_type !== \App\Enum\UserTypes::NORMAL  && (int)auth()->user()->user_type !== \App\Enum\UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        if($request->ajax()){
            return (new AllOfficerAccessApidata($request))->getInCandidates();
        }

        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>true,
            'show_selected_date'=>true,
            'show_medical_status'=>true,
            'show_document_status'=>true,
            'show_visa_status'=>true,
            'show_visa_status'=>true,
            'show_interview_status'=>true,
            'show_evisa_status'=>true,
        ];
        return view('backend.pages.all-officer.in-check', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
        ]);
    }

    public function showDetails($companyCandidateId)
    {
        if((int)auth()->user()->user_type !== \App\Enum\UserTypes::NORMAL  && (int)auth()->user()->user_type !== \App\Enum\UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $companyCandidate = CompanyCandidate::findOrFail($companyCandidateId);

        $visaProcess = VisaProcess::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->first();

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
        return view('backend.pages.all-officer.view', [
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
            'visaProcess'=>$visaProcess,
        ]);
    }
    public function updateDocumentStatus(Request $request, $companyCandidateId)
    {
        
        if((int)auth()->user()->user_type !== \App\Enum\UserTypes::NORMAL  && (int)auth()->user()->user_type !== \App\Enum\UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $validator = Validator::make($request->all(), [
            'status'=>'required|in:Completed,In Progress',
        ]);
        if($validator->fails()){
            return back()->withInput();
        }
        $companyCandidate = CompanyCandidate::findOrFail($companyCandidateId);
        $documentProcess = DocumentProcess::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->firstOrFail();
        $documentProcess->status = $request->status ?? "Completed";
        $documentProcess->save();
        session()->flash('success', 'Successfully The Document Status has been completed');
        return redirect()->route('all-officer.candidate');
    }
    public function proceedToVisa(Request $request)
    {
        if((int)auth()->user()->user_type !== \App\Enum\UserTypes::NORMAL  && (int)auth()->user()->user_type !== \App\Enum\UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $validator = Validator::make($request->all(), [
            'all_candidates'=>'required',
        ]);
        if($validator->fails()){
            session()->flash('error', 'Sorry Unprocessable Data');
            return back()->withInput();
        }
        DB::beginTransaction();
        try {
            $companyCandidates = CompanyCandidate::whereIn('id', (json_decode($request->all_candidates, true) ?? []))->latest()->get();
            $processIds = [];
            foreach ($companyCandidates as $key => $companyCandidate) {
                $demand = CompanyDemand::find($companyCandidate->demand_id);
                $visaProcess = VisaProcess::create([
                    'user_id'=>$companyCandidate->user_id,
                    'company_id'=>$companyCandidate->company_id,
                    'demand_id'=>$companyCandidate->demand_id,
                    'demand_code'=>$demand?->demand_code,
                ]);
                $processIds[] = $visaProcess->refresh()->id;
            }
            try {
                (new CandidateStatusNotificationAction)->proceedToVisa($processIds);
            } catch (\Throwable $th) {
                info("Error While Push Notification ".$th->getMessage());
            }
            DB::commit();
            session()->flash('success', 'Successfuly Proceed To Visa Process');
            return redirect()->route('all-officer.candidate');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return redirect()->route('all-officer.candidate');
        }
    }
    public function notifyDocumentRequirement(Request $request, $companyCandidateId)
    {
        if((int)auth()->user()->user_type !== \App\Enum\UserTypes::NORMAL  && (int)auth()->user()->user_type !== \App\Enum\UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $companyCandidate = CompanyCandidate::findOrFail($companyCandidateId);
        $validator = Validator::make($request->all(), [
            'element_ids'=>'required|array',
            'reasons'=>'required|array',
        ]);
        if($validator->fails()){
            session()->flash('error', 'Sorry Unprocessable Data');
            return back()->withInput();
        }
        try {
            (new CandidateStatusNotificationAction)->sendRequiredDocumentNotification($request, $companyCandidate);
            session()->flash('success', 'Successfully Nootified');
            return back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return back();
        }
    }


    public function getDemands(Request $request)
    {
        $company = Company::findOrFail($request->company);
        $companyUser = User::where('id', $company->user_id)->firstOrFail();
        $demands = CompanyDemand::where('company_id', $companyUser->id)->orderBy('demand_code')->get();
        return response()->json([
            'data'=>$demands,
            'message'=>"Demand List",
        ], 200);
    }
}
