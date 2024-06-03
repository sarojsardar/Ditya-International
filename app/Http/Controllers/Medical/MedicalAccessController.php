<?php

namespace App\Http\Controllers\Medical;

use App\Action\CandidateStatusNotificationAction;
use App\Data\Datatables\MedicalAccessApidata;
use App\Enum\UserTypes;
use App\Http\Controllers\Controller;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\DocumentProcess;
use App\Models\Company;
use App\Models\CompanyCandidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MedicalAccessController extends Controller
{
    public function getIncheckupCandidates(Request $request)
    {
        if((int)auth()->user()->user_type !== UserTypes::MEDICAL_OFFICER){
            abort(401);
        }
        $medicals = auth()->user()->medicals;
        $companies = Company::orderBy('name')->get();
        if($request->ajax()){
            return (new MedicalAccessApidata($request))->getIncheckupCandidates($medicals);
        }
        return view('backend.pages.medical-officer.in-check', ['companies'=>$companies, 'medicals'=>$medicals]);
    }

    public function updateMedicalCheckupStatus(Request $request, $medicalCheckupId)
    {
        if((int)auth()->user()->user_type !== UserTypes::MEDICAL_OFFICER){
            abort(401);
        }
        $validator = Validator::make($request->all(), [
            'status'=>'required|in:Fit,Unfit'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $medicalCheckup = MedicalCheckup::findOrFail($medicalCheckupId);
            $medicalCheckup->is_tested = true;
            $medicalCheckup->status = $request->status;
            $medicalCheckup->save();
            $companyCandidate = CompanyCandidate::where([
                'demand_id'=>$medicalCheckup->demand_id,
                'user_id'=>$medicalCheckup->user_id,
            ])->latest()->first();
            $companyCandidate->medical_status = $request->status;
            $companyCandidate->save();
            DocumentProcess::create([
                'user_id'=>$medicalCheckup->user_id,
                'company_id'=>$medicalCheckup->company_id,
                'demand_id'=>$medicalCheckup->demand_id,
                'demand_code'=>$medicalCheckup->demand_code,
                'status'=>'Started',
                'is_notified'=>false,
                'notified_date'=>Carbon::now(),
                'notified_content'=>null,
            ]);
            try {
                (new CandidateStatusNotificationAction)->updateMedicalCheckupStatus($medicalCheckup->refresh());
            } catch (\Throwable $th) {
                info("Error While Push Notification :".$th->getMessage());
            }
            DB::commit();
            session()->flash('success', 'Successfully Updated');
            return redirect()->route('medical-officer.candidate');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return back();
        }
    }
}
