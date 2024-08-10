<?php

namespace App\Http\Controllers\Document;

use Carbon\Carbon;
use App\Models\User;
use App\Enum\UserTypes;
use App\Models\Company;
use App\Models\Language;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Models\EducationType;
use App\Models\CompanyCandidate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Candidate\VisaProcess;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\DocumentProcess;
use Illuminate\Support\Facades\Validator;
use App\Data\Datatables\DocumentAccessApidata;
use App\Data\Datatables\AllOfficerAccessApidata;
use App\Action\CandidateStatusNotificationAction;
use App\Action\DocumentAction;
use App\Action\FinalDocumentAction;
use App\Enum\CandiateAccessEnum;
use App\Models\Candidate\ETicketProcess;
use App\Models\Candidate\EVisaProcess;
use App\Models\Candidate\FinalJobstatus;
use App\Models\Candidate\LabourPermit;

class DocumentAccessController extends Controller
{

    public function getCandidates(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        if($request->ajax()){
            return (new DocumentAccessApidata($request))->getInCandidates($request->type);
        }
    }
    public function getInCandidates(Request $request)
    {

        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>false,
            'show_interview_status'=>false,
            'show_evisa_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'medical_selected'=>'Fit',
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::NEW_FOR_VISA,
        ]);
    }



    public function showDetails($companyCandidateId)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $companyCandidate = CompanyCandidate::findOrFail($companyCandidateId);

        $documentProcess = DocumentProcess::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->first();


        $visaProcess = VisaProcess::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->first();


        $labourPermit = LabourPermit::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->first();

        $evisa = EVisaProcess::where([
            'user_id'=>$companyCandidate->user_id,
            'company_id'=>$companyCandidate->company_id,
            'demand_id'=>$companyCandidate->demand_id,
        ])->first();

        $eticket = ETicketProcess::where([
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
            'visaProcess'=>$visaProcess,
            'labourPermit'=>$labourPermit,
            'evisa'=>$evisa,
            'eticket'=>$eticket,
            'documentProcess'=>@$documentProcess,
        ]);
    }
    public function updateDocumentStatus(Request $request, $companyCandidateId)
    {
        
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
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
        ])->first();
        if(!$documentProcess){
            $documentProcess = DocumentProcess::create([
                'user_id'=>$companyCandidate->user_id,
                'company_id'=>$companyCandidate->company_id,
                'demand_id'=>$companyCandidate->demand_id,
            ]);
        }

        // dd($documentProcess);
        $documentProcess->status = $request->status ?? "Completed";
        $documentProcess->save();
        session()->flash('success', 'Successfully The Document Status has been completed');
        return redirect()->route('document-officer.candidate');
    }

    public function uploadFinalDocument(Request $request)
    {
        // dd($request->all());
        
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }

        $validator = Validator::make($request->all(), [
            'all_candidates'=>'required',
        ]);
        if($validator->fails()){
            return back()->withInput();
        }

        DB::beginTransaction();
        try {
            (new FinalDocumentAction($request))->uplodaDocument();
            DB::commit();
            session()->flash('success', 'Successfully Document Has Been Uploaded');
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th->getMessage());
            session()->flash('error', $th->getMessage());
             return back();
        }
    }

    public function proceedToVisa(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
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
                $visaProcess = VisaProcess::updateOrcreate([
                    'user_id'=>$companyCandidate->user_id,
                    'company_id'=>$companyCandidate->company_id,
                    'demand_id'=>$companyCandidate->demand_id,
                ],
                [
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
            return redirect()->route('document-officer.candidate');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return redirect()->route('document-officer.candidate');
        }
    }
    public function notifyDocumentRequirement(Request $request, $companyCandidateId)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
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
        // try {
            (new CandidateStatusNotificationAction)->sendRequiredDocumentNotification($request, $companyCandidate);
            session()->flash('success', 'Successfully Nootified');
            return back();
        // } catch (\Throwable $th) {
        //     session()->flash('error', $th->getMessage());
        //     return back();
        // }
    }

    public function visaCalling(Request $request)
    {
            if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
                abort(401);
                exit;
            }
            $medicals = auth()->user()->medicals;
            $companies = Company::orderBy('name')->get();
            if($request->ajax()){
                return (new DocumentAccessApidata($request))->getInCandidates("visa_calling");
            }
            $params = [
                'show_filter'=>true,
                'show_medical'=>false,
                'show_company'=>true,
                'show_demand'=>true,
                'show_checkup_date'=>false,
                'show_interview_status'=>false,
                'show_selected_date'=>false,
                'show_medical_status'=>false,
                'show_document_status'=>false,
                'show_visa_status'=>false,
                'show_evisa_status'=>false,
                'show_labour_permit_status'=>false,
                'show_eticket_status'=>false,
                'show_evisa_status'=>false,
                'show_engaged_status'=>false,
            ];
            return view('backend.pages.document-officer.visa-process', [
                'params'=>$params,
                'companies'=>$companies,
                'medicals'=>$medicals,
                'type'=>CandiateAccessEnum::VISA_CALLING,
            ]);
    }


    public function visaReceived(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>true,
            'show_evisa_status'=>false,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>false,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::VISA_RECEIVED,
        ]);
    }



    public function evisaCalling(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        if($request->ajax()){
            return (new DocumentAccessApidata($request))->getInCandidates("visa_calling");
        }
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>false,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>true,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::EVISA_CALLING,
        ]);
    }


    public function evisaReceived(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>true,
            'show_evisa_status'=>true,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>false,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::EVISA_RECEIVED,
        ]);
    }



    public function finalApproval(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>false,
            'show_evisa_status'=>false,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>false,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::FINAL_APPROVAL,
        ]);
    }



    public function ticketing(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>false,
            'show_evisa_status'=>false,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>false,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::TICKETING,
        ]);
    }
    
    
    public function engaged(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>false,
            'show_evisa_status'=>false,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>false,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::ENGAGED,
        ]);
    }

    public function cancelled(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>false,
            'show_interview_status'=>false,
            'show_selected_date'=>false,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>false,
            'show_evisa_status'=>false,
            'show_labour_permit_status'=>false,
            'show_eticket_status'=>false,
            'show_evisa_status'=>false,
            'show_engaged_status'=>false,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>CandiateAccessEnum::CANCELLED,
        ]);
    }


   

    public function inVisaCandidate(Request $request)
    {
        if((int)auth()->user()->user_type !== \App\Enum\UserTypes::NORMAL  && (int)auth()->user()->user_type !== \App\Enum\UserTypes::DOCUMENT_OFFICER){
            abort(401);
            exit;
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        $params = [
            'show_filter'=>true,
            'show_medical'=>false,
            'show_company'=>true,
            'show_demand'=>true,
            'show_checkup_date'=>true,
            'show_interview_status'=>false,
            'show_selected_date'=>true,
            'show_medical_status'=>false,
            'show_document_status'=>false,
            'show_visa_status'=>true,
            'show_evisa_status'=>true,
            'show_labour_permit_status'=>true,
            'show_eticket_status'=>true,
            'show_evisa_status'=>true,
            'show_engaged_status'=>true,
        ];
        return view('backend.pages.document-officer.visa-process', [
            'params'=>$params,
            'companies'=>$companies,
            'medicals'=>$medicals,
            'type'=>'',
        ]);
    }


    public function propceedToEvisa(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
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
                $visaProcess = EVisaProcess::updateOrcreate([
                    'user_id'=>$companyCandidate->user_id,
                    'company_id'=>$companyCandidate->company_id,
                    'demand_id'=>$companyCandidate->demand_id,
                ],
                [
                    'demand_code'=>$demand?->demand_code,
                ]);
                $processIds[] = $visaProcess->refresh()->id;
            }
            try {
                (new CandidateStatusNotificationAction)->proceedToEVisa($processIds);
            } catch (\Throwable $th) {
                info("Error While Push Notification ".$th->getMessage());
            }
            DB::commit();
            session()->flash('success', 'Successfuly Proceed To Visa Process');
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return back();
        }
    }


    public function updateFinalStatus(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::DOCUMENT_OFFICER){
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
            foreach ($companyCandidates as $key => $companyCandidate) {
                $demand = CompanyDemand::find($companyCandidate->demand_id);

                $company = Company::where('user_id', $demand->company_id)->first();

                $companyCandidate->demand_status = "Completed";
                $companyCandidate->save();
                $user = User::where('id', $companyCandidate->user_id)->first();
                $user->demand_status = "Completed";
                $user->save();

               $finalJob = FinalJobstatus::updateOrCreate([
                        'user_id' => $user->id,
                        'company_id' => $company->id,
                        'demand_id' => $demand->id,
                        'demand_code' => $demand->demand_code,
                    ],[
                        'status' => 1,
                    ]);

            }
            DB::commit();
            session()->flash('success', 'Successfuly Proceed To Visa Process');
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return back();
        }
    }


    public function cancelCandidate(Request $request, $compayCandidateId)
    {
        $companyCandidate = CompanyCandidate::where('id', $compayCandidateId)->first();
        
        $companyCandidate->demand_status = "Cancelled";
        $companyCandidate->save();
        try {
            (new CandidateStatusNotificationAction)->updateCancelledNotification($companyCandidate);
        } catch (\Throwable $th) {
            info("Error While Pushing Notification ".$th->getMessage());
        }
        session()->flash('success', 'Successfully Candidate All Process has been cancelled');
        return back();
    }

    public function uploadDocument(Request $request, $companyCandidateId)
    {
        DB::beginTransaction();
        try {
            $companyCandidate = CompanyCandidate::where('id', $companyCandidateId)->latest()->first();
            (new DocumentAction($request))->uplodaAllDocument($companyCandidate);
            DB::commit();
            session()->flash('success', 'Successfully Uploaded');
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th->getMessage());
            session()->flash('error', $th->getMessage());
            return back();
        }
    }
    
}
