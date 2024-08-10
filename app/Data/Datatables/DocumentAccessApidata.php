<?php

namespace App\Data\Datatables;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enum\CandiateAccessEnum;
use App\Models\CompanyCandidate;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Country;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentAccessApidata
{
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getInCandidates($type="new_for_visa")
    {

        // dd($this->request->all());

        // $company = request()->company;
        // $demand = request()->demand;
        // $medical_status = request()->medical_status;
        // $document_status = request()->document_status;
        // $checkup_date = request()->checkup_date;


        $companyCandidates = CompanyCandidate::query()
            ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
            ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
            ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
            ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
            ->leftJoin('user_details as candidate_details', 'candidate_details.user_id', '=', 'candidates.id')
            ->leftJoin('user_information as candidate_information', 'candidate_information.user_id', '=', 'candidates.id')
            ->leftJoin('upload_photos', 'candidates.id', '=', 'upload_photos.user_id')
            ->leftJoin('medical_checkups', function ($join) {
                $join->on('medical_checkups.user_id', '=', 'candidates.id')
                    ->on('medical_checkups.company_id', '=', 'company_candidates.company_id')
                    ->on('medical_checkups.demand_id', '=', 'company_candidates.demand_id');
            })

            ->leftJoin('document_processes', function ($join) {
                $join->on('document_processes.user_id', '=', 'candidates.id')
                    ->on('document_processes.company_id', '=', 'company_candidates.company_id')
                    ->on('document_processes.demand_id', '=', 'company_candidates.demand_id');
            })


            ->leftJoin('visa_processes', function ($join) {
                $join->on('visa_processes.user_id', '=', 'candidates.id')
                    ->on('visa_processes.company_id', '=', 'company_candidates.company_id')
                    ->on('visa_processes.demand_id', '=', 'company_candidates.demand_id');
            })


            ->leftJoin('evisa_processes', function ($join) {
                $join->on('evisa_processes.user_id', '=', 'candidates.id')
                     ->on('evisa_processes.company_id', '=', 'company_candidates.company_id')
                     ->on('evisa_processes.demand_id', '=', 'company_candidates.demand_id');
            })

            ->leftJoin('eticket_processes', function ($join) {
                $join->on('eticket_processes.user_id', '=', 'candidates.id')
                     ->on('eticket_processes.company_id', '=', 'company_candidates.company_id')
                     ->on('eticket_processes.demand_id', '=', 'company_candidates.demand_id');
            })
    
            ->leftJoin('labour_permits', function ($join) {
                $join->on('labour_permits.user_id', '=', 'candidates.id')
                     ->on('labour_permits.company_id', '=', 'company_candidates.company_id')
                     ->on('labour_permits.demand_id', '=', 'company_candidates.demand_id');
            })
            
            ->leftJoin('final_jobstatuses', function ($join) {
                $join->on('final_jobstatuses.user_id', '=', 'candidates.id')
                     ->on('final_jobstatuses.company_id', '=', 'company_candidates.company_id')
                     ->on('final_jobstatuses.demand_id', '=', 'company_candidates.demand_id');
            })->where([
                'company_candidates.interview_status' => 'Selected',
            ]);

            $companyCandidates->when($this->request->company, function($query, $company){
                $query->where('companies.id', $company);
            })
            ->when($this->request->demand, function($query, $demand){
                $query->where('company_candidates.demand_id', $demand);
            })
            ->when($this->request->medical_status, function($query, $status){
                if($status == "All"){
    
                } elseif($status == "Scheduled"){
                    $query->whereIn('medical_checkups.is_tested',  false)->where('medical_checkups.status', 'N/A');
                }elseif($status == "Tested"){
                    $query->where('is_tested', true);
                }else{
                    $query->where('medical_checkups.status', $status);
                }
            })
            ->when($this->request->selected_date, function($query, $selected_date){
                $selected_date = explode('to', $selected_date);
                $startDate = Carbon::parse($selected_date[0]);
                $endDate = Carbon::parse($selected_date[1] ?? $selected_date[0])->addDay();
                $query->where('interviews.is_selected', true)->whereBetween('interviews.updated_date', [$startDate, $endDate]);
            })
            ->when($this->request->interview_status, function($query, $status){
                switch ($status) {
                    case 'all':
                        // No additional conditions
                        break;
                    case 'scheduled':
                        $query->where('interviews.is_taken', false)->where('is_selected', false);
                        break;
                    case 'selected':
                        $query->where('interviews.is_taken', true)->where('is_selected', true);
                        break;
                    case 'rejected':
                        $query->where('interviews.is_taken', true)->where('is_selected', false);
                        break;
                    case 'KIV':
                        $query->where('interviews.is_taken', true)->where('company_candidates.interview_status', 'KIV'); 
                        break;
                    default:
                        // No additional conditions
                        break;
                }
            })
            ->when($this->request->checkup_date, function($query, $checkup_date){
                $checkup_date = explode('to', $checkup_date);
                $startDate = Carbon::parse($checkup_date[0]);
                $endDate = Carbon::parse($checkup_date[1] ?? $checkup_date[0])->addDay();
                $query->whereBetween('medical_checkups.checkup_date', [$startDate, $endDate]);
            })
            ->when($this->request->visa_status, function($query, $visa_status){
                $query->where('visa_processes.status', $visa_status);
            })
            ->when($this->request->evisa_status, function($query, $evisa_status){
                if($evisa_status == "Pending"){
                    $query->where('evisa_processes.status', null);
                }else{
                    $query->where('evisa_processes.status', $evisa_status);
                }
            })
            ->when($this->request->document_status, function($query, $document_status){
                $query->where('document_processes.status', $document_status);
            })
            ->when($this->request->labour_permit_status, function($query, $labour_permit_status){
                if($labour_permit_status == "Pending"){
                    $query->where('labour_permits.status', null);
                }else{
                    $query->where('labour_permits.status', $labour_permit_status);
                }
            })
            ->when($this->request->eticket_status, function($query, $eticket_status){
                if($eticket_status == "Pending"){
                    $query->where('eticket_processes.status', null);
                }else{
                    $query->where('eticket_processes.status', $eticket_status);
                }
            })
    
            ->when($this->request->engaged_status, function($query, $engaged_status){
                $query->where('final_jobstatuses.status', (int)$engaged_status);
            });



            
            switch ($type) {
                case CandiateAccessEnum::NEW_FOR_VISA:
                    $companyCandidates->where([
                        'company_candidates.demand_status'=>'Interview',
                        'company_candidates.interview_status'=>'Selected',
                        'company_candidates.medical_status'=>'Fit',
                    ])->where('visa_processes.id', '=', null)
                    ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::VISA_CALLING:
                    $companyCandidates->whereIn('visa_processes.status', ['N/A', 'Pending', 'In Progress'])
                    ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::VISA_RECEIVED:
                    $companyCandidates->whereIn('visa_processes.status', ['Successed', 'Rejected'])
                    ->where('evisa_processes.id', '=', null)
                    ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::EVISA_CALLING:
                    $companyCandidates->whereIn('evisa_processes.status', ['N/A', 'Pending', 'In Progress'])
                    ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::EVISA_RECEIVED:
                    $companyCandidates->whereIn('evisa_processes.status', ['Successed', 'Rejected'])
                        ->where('labour_permits.id', '=', null)
                        ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::FINAL_APPROVAL:
                    $companyCandidates->whereIn('visa_processes.status', ['Successed'])
                        ->whereIn('labour_permits.status', ['Successed'])
                        ->whereIn('eticket_processes.status', ['Successed'])
                        ->where('candidates.demand_status', '!=', "Completed")
                        ->where('company_candidates.demand_status', '!=', "Completed")
                        ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::TICKETING:
                    $companyCandidates->whereIn('visa_processes.status', ['Successed'])
                        ->whereIn('labour_permits.status', ['Successed'])
                        ->whereIn('eticket_processes.status', ['Successed'])
                        ->where('candidates.demand_status', '!=', "Completed")
                        ->where('company_candidates.demand_status', '!=', "Completed")
                        ->where('final_jobstatuses.id', null)
                        ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;

                case CandiateAccessEnum::ENGAGED:
                    $companyCandidates->whereIn('visa_processes.status', ['Successed'])
                        ->whereIn('labour_permits.status', ['Successed'])
                        ->whereIn('eticket_processes.status', ['Successed'])
                        ->where('candidates.demand_status', "Completed")
                        ->where('company_candidates.demand_status', "Completed")
                        ->where('final_jobstatuses.status', 1)
                        ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;
                case CandiateAccessEnum::CANCELLED:
                    $companyCandidates->where('company_candidates.demand_status', '=',  'Cancelled');
                break;
                
                case CandiateAccessEnum::IN_VISA:
                        $companyCandidates->where([
                            'company_candidates.demand_status'=>'Interview',
                            'company_candidates.interview_status'=>'Selected',
                        ])->where('visa_processes.status', '!=', null)
                        ->where('company_candidates.demand_status', '!=',  'Cancelled');
                    break;

                

                case CandiateAccessEnum::IN_DOCUMENT:
                    $companyCandidates->where([
                        'company_candidates.demand_status'=>'Interview',
                        'company_candidates.interview_status'=>'Selected',
                    ])
                    ->where('company_candidates.demand_status', '!=',  'Cancelled');
                break;
                    
                case CandiateAccessEnum::IN_MEDICAL:
                    $companyCandidates->where('medical_checkups.id', '!=', null)
                    ->where('company_candidates.demand_status', '!=',  'Cancelled');
                    break;
                                
                default:
                    # code...
                    break;
            }

            $companyCandidates->select([
                'company_candidates.*',

                'companies.name as company_name',
                'companies.address as company_address',
                'companies.logo as company_logo',
                'companies.country as company_country',
                'company_user.id as company_user_id',

                'candidates.id as candidate_id',
                'candidates.email as candidate_email',

                'candidate_details.full_name as candidate_full_name',
                'candidate_details.permanent_address as candidate_permanent_address',
                'candidate_details.temporary_address as candidate_temporary_address',
                'candidate_details.gender as candidate_gender',
                'candidates.mobile_no as candidate_contact',

                'candidate_information.first_name as candidate_first_name',
                'candidate_information.last_name as candidate_last_name',
                'candidate_information.middle_name as middle_name',
                'candidate_information.full_address as candidate_full_address',
                'upload_photos.passport_photo as candidate_profile_picture',

                'medical_checkups.medical_id',
                'medical_checkups.checkup_date',
                'medical_checkups.status as checkup_medical_status',
                'medical_checkups.is_tested',
                
                'document_processes.status as document_status',
                'visa_processes.status as visa_status',
                'evisa_processes.status as evisa_status',

                'eticket_processes.status as eticket_status',
                'labour_permits.status as labour_permit_status',
                'final_jobstatuses.status as job_status',
                // new developed
                'candidates.demand_status as user_demand_status',
            ])->distinct();


            // dd($companyCandidates->toSql());

        return DataTables::of($companyCandidates)
            ->addIndexColumn()
            ->addColumn('checkup_date', function ($row) {
                return Carbon::parse($row->checkup_date)->format('Y-m-d g:i A');
            })
            ->editColumn('medical_status', function ($row) {
                $returnString = "Not Tested";
                if ($row->checkup_medical_status == "Fit") {
                    $returnString = '<span class="badge bg-primary text-white">' . $row->checkup_medical_status . '</span>';
                }
                if ($row->checkup_medical_status == "Unfit") {
                    $returnString = '<span class="badge bg-danger text-white">' . $row->checkup_medical_status . '</span>';
                }
                return $returnString;
            })
            ->addColumn('company_info', function ($row) {
                $country = Country::where('id', $row->company_country)->first();
                $return_string = '
                    <div>
                        <p class="p-0 m-0">Company Name:<a href="#">' . $row->company_name . '</a></p>
                        <p class="p-0 m-0">Country: ' . $country?->name . ' </p>
                        <p class="p-0 m-0">Address: ' . $row->company_address . '</p>
                    </div>
                ';
                return $return_string;
            })
            ->addColumn('logo', function ($row) {
                $url = url('/storage/uploads/company-logo/' . $row->company_logo);
                return "<img src='{$url}' alt='company logo' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('candidate_info', function ($row) {
                $showUrl = route('document-officer.show-candidate', $row->id);
                $return_string = '
                    <div>
                        <p class="p-0 m-0">Name:<a href="' . $showUrl . '">' . $row->candidate_full_name . '</a></p>
                        <p class="p-0 m-0">Permanent Asddress: ' . $row->candidate_permanent_address . ' </p>
                         <p class="p-0 m-0">Temporary Asddress: ' . $row->candidate_temporary_address . ' </p>
                        <p class="p-0 m-0">Gender: ' . ucfirst($row->candidate_gender) . '</p>
                        <p class="p-0 m-0">Email: ' . $row->candidate_email . '</p>
                        <p class="p-0 m-0">Contact: ' . $row->candidate_contact . '</p>
                    </div>
                ';
                return $return_string;
            })
            ->addColumn('profile', function ($row) {
                $url = url('/storage/uploads/passport-photos/' . $row->candidate_profile_picture);
                return "<img src='{$url}' alt='Profile Picture' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('document-officer.show-candidate', $row->id);
                $action = '<a href="' . $showUrl . '">View Details</a>';
                return $action;
            })
            ->rawColumns(['DT_RowIndex', 'profile', 'candidate_info', 'medical_status', 'company_info', 'logo', 'action', 'selected'])
            ->make(true);
    }
}
