<?php
namespace App\Data\Datatables;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enum\CandiateAccessEnum;
use App\Models\CompanyCandidate;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate\FinalJobstatus;
use Yajra\DataTables\Facades\DataTables;


class AllOfficerAccessApidata
{
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }
    private function getQueries($type="in_visa")
    {
        $request = request();
        $companyCandidates = CompanyCandidate::query()
        ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
        ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
        ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
        ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
        ->leftJoin('user_details as candidate_details', 'candidate_details.user_id', '=', 'candidates.id')
        ->leftJoin('user_information as candidate_information', 'candidate_information.user_id', '=', 'candidates.id')
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


        ->leftJoin('interviews', function ($join) {
            $join->on('interviews.user_id', '=', 'candidates.id')
                 ->on('interviews.demand_id', '=', 'company_candidates.demand_id');
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
        ->where([
            // 'company_candidates.demand_status'=>'Interview',
            // 'company_candidates.interview_status'=>'Selected',
        ]);

        switch ($type) {
            case CandiateAccessEnum::IN_VISA:
                    $companyCandidates->where([
                        'company_candidates.demand_status'=>'Interview',
                        'company_candidates.interview_status'=>'Selected',
                    ])->where('visa_processes.status', '!=', null);
                break;
            case CandiateAccessEnum::IN_DOCUMENT:
                $companyCandidates->where([
                    'company_candidates.demand_status'=>'Interview',
                    'company_candidates.interview_status'=>'Selected',
                ]);
                break;
                
            case CandiateAccessEnum::IN_MEDICAL:
                $companyCandidates->where('medical_checkups.id', '!=', null);
                break;
                            
            default:
                # code...
                break;
        }
        $companyCandidates->when($request->company, function($query, $company){
            $query->where('companies.id', $company);
        })
        ->when($request->demand, function($query, $demand){
            $query->where('company_candidates.demand_id', $demand);
        })
        ->when($request->medical_status, function($query, $status){
            if($status == "All"){

            } elseif($status == "Scheduled"){
                $query->whereIn('medical_checkups.is_tested',  false)->where('medical_checkups.status', 'N/A');
            }elseif($status == "Tested"){
                $query->where('is_tested', true);
            }else{
                $query->where('medical_checkups.status', $status);
            }
        })
        ->when($request->selected_date, function($query, $selected_date){
            $selected_date = explode('to', $selected_date);
            $startDate = Carbon::parse($selected_date[0]);
            $endDate = Carbon::parse($selected_date[1] ?? $selected_date[0])->addDay();
            $query->where('interviews.is_selected', true)->whereBetween('interviews.updated_date', [$startDate, $endDate]);
        })
        ->when($request->interview_status, function($query, $status){
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
        ->when($request->checkup_date, function($query, $checkup_date){
            $checkup_date = explode('to', $checkup_date);
            $startDate = Carbon::parse($checkup_date[0]);
            $endDate = Carbon::parse($checkup_date[1] ?? $checkup_date[0])->addDay();
            $query->whereBetween('medical_checkups.checkup_date', [$startDate, $endDate]);
        })
        ->when($request->visa_status, function($query, $visa_status){
            $query->where('visa_processes.status', $visa_status);
        })
        ->when($request->evisa_status, function($query, $evisa_status){
            $query->where('evisa_processes.status', $evisa_status);
        })
        ->when($request->document_status, function($query, $document_status){
            $query->where('document_processes.status', $document_status);
        })

        ->select([
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

            'candidate_information.first_name as candidate_first_name',
            'candidate_information.last_name as candidate_last_name',
            'candidate_information.middle_name as middle_name',
            'candidate_information.full_address as candidate_full_address',
            'candidate_information.contact as candidate_contact',
            'candidate_information.profile_picture as candidate_profile_picture',

            'medical_checkups.medical_id',
            'medical_checkups.checkup_date',
            'medical_checkups.status as medical_status',
            'medical_checkups.is_tested',

            'document_processes.status as document_status',
            'visa_processes.status as visa_status',
            'evisa_processes.status as evisa_status',
        ]);

        return $companyCandidates;
    }
    public function getInCandidates()
    {
        $companyCandidates = $this->getQueries();
        return DataTables::of($companyCandidates)
            ->addIndexColumn()
            ->addColumn('checkup_date', function($row){
                return Carbon::parse($row->checkup_date)->format('Y-m-d g:i A');
            })
            ->addColumn('company_info', function($row){
                $return_string = '
                    <div>
                        <p class="p-0 m-0">Company Name:<a href="#">'.$row->company_name.'</a></p>
                        <p class="p-0 m-0">Country: '.$row->company_country.' </p>
                        <p class="p-0 m-0">Address: '.$row->company_address.'</p>
                    </div>
                ';
                return $return_string;
            })
            ->addColumn('logo', function($row){
                $url = url('/storage/uploads/company-logo/'. $row->company_logo);
                return "<img src='{$url}' alt='company logo' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('candidate_info', function($row){
                $showUrl = route('document-officer.show-candidate', $row->id);
                
                $final_job_status = "Open To Work/ Not Engaged";

                $finalJobstatus = FinalJobstatus::where('user_id', $row->user_id)->latest()->first();
                if($finalJobstatus){
                    $final_job_status = $finalJobstatus->status;
                }
                $return_string = '
                    <div>
                        <p class="p-0 m-0">Name:<a href="'.$showUrl.'">'.$row->candidate_full_name.'</a></p>
                        <p class="p-0 m-0">Country: '.$row->candidate_full_address.' </p>
                        <p class="p-0 m-0">Gender: '.$row->candidate_gender.'</p>
                        <p class="p-0 m-0">Email: '.$row->candidate_email.'</p>
                        <p class="p-0 m-0">Contact: '.$row->candidate_contact.'</p>
                        <p class="p-0 m-0">Interview Status: '.$row->interview_status.'</p>
                        <p class="p-0 m-0">Medical Status: '.$row->medical_status.'</p>
                        <p class="p-0 m-0">Document Status: '.$row->document_status.'</p>
                        <p class="p-0 m-0">Visa Status: '.$row->visa_status.'</p>
                        <p class="p-0 m-0">Final Job Status: '.$final_job_status.'</p>
                        
                    </div>
                ';
                return $return_string;
            })
            ->addColumn('profile', function($row){
                $url = url('/storage/uploads/company-logo/'. $row->candidate_profile_picture);
                return "<img src='{$url}' alt='Profile Picture' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('action', function($row){
                $showUrl = route('document-officer.show-candidate', $row->id);
                $action = '<a href="'.$showUrl.'">View Details</a>';
                return $action;
            })
            ->rawColumns(['DT_RowIndex', 'profile', 'candidate_info', 'company_info', 'logo', 'action', 'selected'])
            ->make(true);
        }
}