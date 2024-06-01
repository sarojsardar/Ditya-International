<?php

namespace App\Http\Controllers\Document;

use App\Enum\UserTypes;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\CompanyCandidate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Candidat\MedicalCheckup;
use Illuminate\Support\Facades\Validator;
use App\Data\Datatables\MedicalAccessApidata;
use App\Data\Datatables\DocumentAccessApidata;
use App\Action\CandidateStatusNotificationAction;

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
            return (new DocumentAccessApidata($request))->getIncheckupCandidates($medicals);
        }
        return view('backend.pages.document-officer.in-check', ['companies'=>$companies, 'medicals'=>$medicals]);
    }

    public function sendNotification(Request $request)
    {
        
    }
}
