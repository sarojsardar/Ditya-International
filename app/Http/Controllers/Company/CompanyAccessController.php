<?php

namespace App\Http\Controllers\Company;

use App\Action\CandidateStatusNotificationAction;
use App\Action\FileSupportAction;
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
use App\Data\Datatables\CompanyAccessApidata;
use App\Models\Candidate\DocumentProcess;
use App\Models\Candidate\VisaProcess;
use App\Models\Interview;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyAccessController extends Controller
{
    public function getInCandidates(Request $request)
    {

        if((int)auth()->user()->user_type !== UserTypes::COMPANY){
            abort(401);
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        if($request->ajax()){
            return (new CompanyAccessApidata($request))->getInCandidates();
        }
        return view('backend.pages.company-officer.in-check', ['companies'=>$companies, 'medicals'=>$medicals]);
    }

    public function showDetails($companyCandidateId)
    {
        if((int)auth()->user()->user_type !== UserTypes::COMPANY){
            abort(401);
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
        return view('backend.pages.company-officer.view', [
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
        if((int)auth()->user()->user_type !== UserTypes::COMPANY){
            abort(401);
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
        return redirect()->route('document-officer.candidate');
    }
    public function proceedToVisa(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::COMPANY){
            abort(401);
        }
        $rules = [
            'all_candidates'=>'required',
            'status'=>'required|in:Successed,Rejected',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            session()->flash('error', 'Sorry Unprocessable Data');
            return back();
        }

        if($request->status == 'Successed'){
            $rules['visa'] = 'required|mimes:pdf';
        }
        if($request->status == 'Rejected'){
            $rules['reason'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            session()->flash('error', 'Sorry Unprocessable Data');
            return back();
        }
        DB::beginTransaction();
        try {
            $companyCandidates = CompanyCandidate::whereIn('id', (json_decode($request->all_candidates, true) ?? []))->latest()->get();
            $processIds = [];
            
            $visa = null;
            if($request->has('visa')){
                $visa = (new FileSupportAction)->uploadFile($request->visa, 'visa');
            }
            foreach ($companyCandidates as $key => $companyCandidate) {
                $demand = CompanyDemand::find($companyCandidate->demand_id);
                $visaProcess = VisaProcess::where([
                    'user_id'=>$companyCandidate->user_id,
                    'company_id'=>$companyCandidate->company_id,
                    'demand_id'=>$companyCandidate->demand_id,
                    'demand_code'=>$demand->demand_code,
                ])->first();
                if($visaProcess){
                    $visaProcess->update([
                        'status'=>$request->status,
                        'reason'=>$request->reason ?? null,
                        'visa'=>$visa,
                    ]);
                    $processIds[] = $visaProcess->refresh()->id;
                }
            }
            try {
                (new CandidateStatusNotificationAction)->updateVisaStatus($processIds, $request->status);
            } catch (\Throwable $th) {
                info("Error While Push Notification ".$th->getMessage());
            }
            DB::commit();
            session()->flash('success', 'Successfuly Proceed To Visa Process');
            return redirect()->route('company-officer.candidate');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return redirect()->route('company-officer.candidate');
        }
    }
}
