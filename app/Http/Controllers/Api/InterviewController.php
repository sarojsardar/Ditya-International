<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Country;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Enum\UserDemandStatus;
use App\Models\CompanyCandidate;
use App\Enum\UserInterviewStatus;
use App\Action\NotificationAction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Candidate\VisaProcess;
use App\Models\Candidate\EVisaProcess;
use App\Models\Candidate\LabourPermit;
use App\Http\Resources\CompanyResource;
use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\ETicketProcess;
use App\Models\Candidate\DocumentProcess;
use App\Models\Candidate\FinalJobstatus;

class InterviewController extends Controller
{
    //
    public function interviews(Request $request)
    {
        // Retrieve the authenticated user's ID
        $userID = auth()->id();
        $interviews = CompanyCandidate::query()
        ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
        ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
        ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
        ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
        ->leftJoin('interviews', function ($join) {
            $join->on('interviews.user_id', '=', 'candidates.id')
                ->on('interviews.demand_id', '=', 'company_candidates.demand_id');
        })
        ->where('company_candidates.user_id', $userID)
        
        ->when($request->type, function($query, $type) {
            if($type == "attend"){
                $query->where('interviews.is_taken', true);
            }
            if($type == "selected"){
                $query->where('interviews.is_taken', true)
                ->where('interviews.user_accept_status', 'Accepted')      
                ->where('interviews.is_selected', true);
            }
            if($type == "rejected"){
                $query->where('interviews.is_taken', true)
                ->where('interviews.user_accept_status', 'Accepted')      
                ->where('interviews.is_selected', false);
            }
        })   
        ->select([
            'company_candidates.*',
            'company_candidates.id as caompany_candidate_id',
            'interviews.*',
            'interviews.id as interview_id',
            'companies.name as company_name',
            'companies.address as company_address',
            'companies.logo as company_logo',
            'companies.country as company_country',
            'company_user.id as company_user_id',
        ])
        ->get();

        return response()->json([
            'success' => true,
            'message'=>'Interview List',
            'data' => $interviews,
        ]);
    }


    public function interviewInvites() {
        $userID = auth()->id(); // Retrieve the authenticated user's ID
        // What the fuck laude code
        // Directly retrieve CompanyCandidate records for the authenticated user, including interview data

        $now = Carbon::now();
        $interviews = CompanyCandidate::query()
            ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
            ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
            ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
            ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
            ->leftJoin('interviews', function ($join) {
                $join->on('interviews.user_id', '=', 'candidates.id')
                    ->on('interviews.demand_id', '=', 'company_candidates.demand_id');
            })
            ->where('company_candidates.user_id', $userID)
            ->where('interviews.is_taken', false)
            // ->where(DB::raw("CONCAT(interview_date, ' ', interview_time)"), '>=', $now)

            ->where('company_candidates.demand_status', UserDemandStatus::Approved)
            ->where('company_candidates.interview_status', UserInterviewStatus::Pending)
            ->where(function($q) {
                $q->whereNotNull('interviews.interview_date')
                  ->orWhere('interviews.interview_date', '!=', '');
            })
            ->select([
                'company_candidates.*',
                'company_candidates.id as caompany_candidate_id',
                'interviews.*',
                'interviews.id as interview_id',
                'companies.name as company_name',
                'companies.address as company_address',
                'companies.logo as company_logo',
                'companies.country as company_country',
                'company_user.id as company_user_id',
            ])
            ->get();
        return response()->json([
            'success' => true,
            'data' => $interviews,
        ]);
    }



    public function updateStatus(Request $request, $interviewId)
    {
            $user = auth()->user();
            $interview = Interview::where('id', $interviewId)->where('user_id', $user->id)->firstOrFail();
            $companyDemand = CompanyDemand::where('id', $interview->demand_id)->whereIn('status', ['Open', 'Pending'])->latest()->first();
            $companyCandiate = CompanyCandidate::where('demand_id', $companyDemand->id)->where('user_id', $user->id)->latest()->first();
            $company = Company::where('id', $companyCandiate->company_id)->first();
            $companyUser = User::where('id', $company->user_id)->first();
            if(!$companyDemand){
                return response()->json([
                    'message'=>'Demand Not Open, Or May be completed or closed',
                    'status'=>404,
                ], 404);
            }
            // Validate the request data
            $validatedData = $request->validate([
                'interview_status' => 'required', // Adjust validation rules as needed
            ]);

            // What the fuck laude code
            // Find the CompanyCandidate by user_id, throw a ModelNotFoundException if not found
            $companyUser = User::where('id', $companyDemand->company_id)->first();
            if(!$companyUser){
                return response()->json([
                    'message'=>'Demand Not Open, Or May be completed or closed',
                    'status'=>404,
                ], 404);
            }
            $company = Company::where('user_id', $companyUser->id)->first();
            $companyCandidate = CompanyCandidate::where('company_id', $company->id)->where('user_id', $user->id)->where('demand_id', $companyDemand->id)->latest()->firstOrFail();
            // Update the CompanyCandidate's interview status
            $companyCandidate->interview_status = $validatedData['interview_status'];
            $companyCandidate->demand_status = UserDemandStatus::Interview;
            $companyCandidate->save();
            try {
                $interview = Interview::where([
                    'demand_id'=>$companyDemand->id,
                    'demand_code'=>$companyDemand->demand_code,
                    'user_id'=>$user->id,
                    'user_accept_status'=>'Pending',
                    'is_taken'=>false,
                    'is_selected'=>false,
                ])->latest()->first();
                if($interview){
                    $interview->user_accept_status = $validatedData['interview_status'];
                    $interview->save();
                }

                $generated_by = get_class(auth()->user());
                $generated_id = auth()->user()->id;
                // This may be change according to the candidate model 
                
                $generated_to = get_class($company?->user ?? new User());
                $generated_to_id = $company?->user?->id ?? 0;

                $title = "$user->name has been".  $validatedData['interview_status'] ."your interview proposal by the company".  $company->name;
                $go_to_url = "#";
                // in the below the href must be changed;
                $web_content = "$user->name has been".  $validatedData['interview_status'] ."your interview proposal by the company".  $company->name;
                $mobile_content = "$user->name has been".  $validatedData['interview_status'] ."your interview proposal by the company".  $company->name;
                $is_auto = true;
                $send_to = 4;


                (new NotificationAction(
                    $title,
                    $web_content,
                    $mobile_content,
                    $is_auto,
                    $generated_by,
                    $generated_id,
                    $generated_to,
                    $generated_to_id,
                    $send_to,
                    $go_to_url,
                    ))->pushNotification();
                    

                $generated_to = "System";
                $generated_to_id = 0;
                (new NotificationAction(
                        $title,
                        $web_content,
                        $mobile_content,
                        $is_auto,
                        $generated_by,
                        $generated_id,
                        $generated_to,
                        $generated_to_id,
                        $send_to,
                        $go_to_url,
                        ))->pushNotification();
            } catch (\Throwable $th) {
                info("Error While Updating Status of the interview: ".$th->getMessage());
            }

            // Return a successful response
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ], 200);

    }


    public function interviewProcess(Request $request, $id)
    {
        $user = auth()->user();
        $interview = Interview::where('user_id', $user->id)->where('id', $id)->first();
        if(!$interview){
            return response()->json([
                'success'=>false,
                'message'=>"Not Found",
                'data'=>[],
            ], 400);
        }
        $companyCandidates = CompanyCandidate::query()
        ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
        ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
        ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
        ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
        ->leftJoin('user_details as candidate_details', 'candidate_details.user_id', '=', 'candidates.id')
        ->leftJoin('user_information as candidate_information', 'candidate_information.user_id', '=', 'candidates.id')
        ->leftJoin('upload_photos', 'candidates.id', '=', 'upload_photos.user_id')

        ->leftJoin('interviews', function ($join) {
            $join->on('interviews.user_id', '=', 'candidates.id')
                ->on('interviews.demand_id', '=', 'company_candidates.demand_id');
        })


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
        })->where('company_candidates.user_id', $user->id)
        ->where('interviews.id', $interview->id);

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
            'interviews.*',
        ])->distinct()->first();

        return response()->json([
            'success'=>false,
            'message'=>"Not Found",
            'data'=>$companyCandidates,
        ], 400);
    }
    
    public function applicationProcess(Request $request)
    {
       $user = auth()->user();
       $companyCandidate =  $companyCandidates = CompanyCandidate::query()
       ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
       ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
       ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
       ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
       ->leftJoin('user_details as candidate_details', 'candidate_details.user_id', '=', 'candidates.id')
       ->leftJoin('user_information as candidate_information', 'candidate_information.user_id', '=', 'candidates.id')
       ->leftJoin('upload_photos', 'candidates.id', '=', 'upload_photos.user_id')
       ->where('company_candidates.user_id', $user->id)
       ->orderBy('id', 'desc')
       ->select([
        'company_candidates.*',
        'companies.name as company_name',
        'companies.address as company_address',
        'companies.logo as company_logo',
        'companies.country as company_country',
        'company_user.id as company_user_id',

        'candidates.id as candidate_id',
        'candidates.email as candidate_email',

        'demand_code',
        'company_demands.gender as demand_gender',
        'age_from',
        'age_to',
        'company_demands.height as demand_height',
        'company_demands.weight as demand_weight',
        'experience_year',
        'education',
        'edu_level',
        'demand_letter',
        'company_demands.status as demand_status',
       ])->get();


      $processes =[];
       foreach ($companyCandidate as $key => $candidate) {
        $process = [];
        $process = [
            'company_info'=>[
                'id'=>$candidate->company_id,
                'company_name'=>$candidate->company_name,
                'company_logo'=>$candidate->company_logo,
                'company_address'=>$candidate->company_address,
                'company_country'=>Country::where('id', $candidate->company_country)->first()?->name,
            ],
            'demand_info'=>[
                'demand_code'=>$candidate->demand_code,
                'gender'=>$candidate->demand_gender,
                'age_from'=>$candidate->age_from,
                'age_to'=>$candidate->age_to,
                'height'=>$candidate->demand_height,
                'weight'=>$candidate->demand_weight,
                'experience_year'=>$candidate->experience_year,
                'education'=>$candidate->education,
                'edu_level'=>$candidate->edu_level,
                'demand_letter'=>$candidate->demand_letter,
                'demand_status'=>$candidate->demand_status,
            ],
        ];
            $steps = [];
            $steps[] = [
                'step'=>1,
                'message'=>'Wishlisted',
                'data'=>[],
            ];


            $interview = Interview::where([
                'demand_id'=>$candidate->demand_id,
                'user_id'=>$user->id,
            ])->latest()->first();

            if($interview){
                $steps[] = [
                    'step'=>2,
                    'message'=>'Interview Process Started',
                    'data'=>$interview,
                ];

                if($interview->user_accept_status == "Accepted" || $interview->user_accept_status=="Declined"){
                    $steps[] = [
                        'step'=>3,
                        'message'=>'Interview '.$interview->user_accept_status .' By You',
                        'data'=>$interview,
                    ];
                }
                if($interview->user_accept_status == "Accepted"){
                    if($interview->interview_date !== null && $interview->interview_date !== ''){
                        $steps[] = [
                            'step'=>4,
                            'message'=>'Interview Scheduled',
                            'data'=>$interview,
                        ];
                    }
                    if($interview->user_accept_status == "Accepted" && (bool)$interview->is_taken){
                        $steps[] = [
                            'step'=>5,
                            'message'=>'Interview Attended',
                            'data'=>$interview,
                        ];
                    }
    
    
    
                    if($interview->user_accept_status == "Accepted" && (bool)$interview->is_taken){
                        $message = "Rejected";
                        if((bool)$interview->is_selected){
                            $steps[] = [
                                'step'=>6,
                                'message'=>'Selected',
                                'data'=>$interview,
                            ];
                        }
                    }
    
    
    
                    if($interview->user_accept_status == "Accepted" && (bool)$interview->is_taken){
                        if((bool)$interview->is_selected){
                            $medicalCheckup = MedicalCheckup::where([
                                'company_id'=>$candidate->company_id,
                                'demand_id'=>$candidate->demand_id,
                                'user_id'=>$user->id,
                            ])->latest()->first();
                
                            if($medicalCheckup){
                                $steps[] = [
                                    'step'=>7,
                                    'message'=>'Medical Checkup Scheduled',
                                    'data'=>$medicalCheckup,
                                ];
                                if((bool)$medicalCheckup->is_tested){
                                    $steps[] = [
                                        'step'=>8,
                                        'message'=>'Medical Checkup Done',
                                        'data'=>$medicalCheckup,
                                    ];
    
                                    if($medicalCheckup->status == "Fit"){
                                        $documentProcess = DocumentProcess::where([
                                            'user_id'=>$candidate->user_id,
                                            'company_id'=>$candidate->company_id,
                                            'demand_id'=>$candidate->demand_id,
                                        ])->first();
                            
                                        if($documentProcess){
                                            $steps[] = [
                                                'step'=>9,
                                                'message'=>'Document Process Started',
                                                'data'=>$documentProcess,
                                            ];
                                        }
                            
                            
                                        if($documentProcess){
                                            if($documentProcess->status == "Completed"){
                                                $steps[] = [
                                                    'step'=>10,
                                                    'message'=>'Document Process Completed',
                                                    'data'=>$documentProcess,
                                                ];
    
    
                                                if($documentProcess->status == "Completed"){
                                                    $visaProcess = VisaProcess::where([
                                                        'user_id'=>$candidate->user_id,
                                                        'company_id'=>$candidate->company_id,
                                                        'demand_id'=>$candidate->demand_id,
                                                    ])->first();
                                        
                                        
                                                    if($visaProcess){
                                                        $steps[] = [
                                                            'step'=>11,
                                                            'message'=>'Visa Process Started',
                                                            'data'=>$visaProcess,
                                                        ];
    
    
                                                        $message = 'Visa Process '.$visaProcess->status;
                                                        $steps[] = [
                                                            'step'=>12,
                                                            'message'=>$message,
                                                            'data'=>$visaProcess,
                                                        ];
                                                        if($visaProcess->status == "Successed"){
                                                            $evisa = EVisaProcess::where([
                                                                'user_id'=>$candidate->user_id,
                                                                'company_id'=>$candidate->company_id,
                                                                'demand_id'=>$candidate->demand_id,
                                                            ])->first();
                                                
                                                            if($evisa){
                                                                $steps[] = [
                                                                    'step'=>13,
                                                                    'message'=>'E Visa Process Started',
                                                                    'data'=>$evisa,
                                                                ];
    
    
    
                                                                $message = 'E Visa Process '.$evisa->status;
                                                                $steps[] = [
                                                                    'step'=>14,
                                                                    'message'=>$message,
                                                                    'data'=>$evisa,
                                                                ];
                                                                if($evisa->status == "Successed"){
                                                                    $labourPermit = LabourPermit::where([
                                                                        'user_id'=>$candidate->user_id,
                                                                        'company_id'=>$candidate->company_id,
                                                                        'demand_id'=>$candidate->demand_id,
                                                                    ])->first();
                                                        
                                                        
                                                                    
                                                                    if($labourPermit){
                                                                        $steps[] = [
                                                                            'step'=>15,
                                                                            'message'=>'Permit Process Started',
                                                                            'data'=>$labourPermit,
                                                                        ];
    
                                                                        $message = 'Permit Process '.$labourPermit->status;
                                                                        $steps[] = [
                                                                            'step'=>16,
                                                                            'message'=>$message,
                                                                            'data'=>$evisa,
                                                                        ];
    
    
                                                                        if($labourPermit->status == "Successed"){
                                                                            $eticket = ETicketProcess::where([
                                                                                'user_id'=>$candidate->user_id,
                                                                                'company_id'=>$candidate->company_id,
                                                                                'demand_id'=>$candidate->demand_id,
                                                                            ])->first();
                                                                
                                                                
                                                                            if($eticket){
                                                                                $steps[] = [
                                                                                    'step'=>17,
                                                                                    'message'=>'Ticket Process Started',
                                                                                    'data'=>$eticket,
                                                                                ];
    
                                                                                $message = 'Ticket Process '.$eticket->status;
                                                                                $steps[] = [
                                                                                    'step'=>18,
                                                                                    'message'=>$message,
                                                                                    'data'=>$evisa,
                                                                                ];
    
                                                                                if($eticket->status == "Successed"){
                                                                                    $finaleJob = FinalJobstatus::where([
                                                                                        'user_id'=>$candidate->user_id,
                                                                                        'company_id'=>$candidate->company_id,
                                                                                        'demand_id'=>$candidate->demand_id,
                                                                                    ])->first();
                                                                        
                                                                                    if($finaleJob){
                                                                                        if((int)$finaleJob->status == 1){
                                                                                            $steps[] = [
                                                                                                'step'=>19,
                                                                                                'message'=>"Engaged On Job",
                                                                                                'data'=>$evisa,
                                                                                            ];
                                                                                        }
                                                                                    }
                                                                        
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
    
                                                            }
    
                                                        }
    
                                                    }
                                                }
                                            }
                                        }
                            
                                    }
                                }
    
                            }
                        }
                    } 
                }
            }
            $process['steps']=$steps;
            $processes[] = $process;
       }
       return response()->json([
            'success'=>true,
            'message'=>'Application Process',
            'data'=>$processes,
       ]);
    }




    public function showInterviewProcess(Request $request, $id)
    {
        $user = auth()->user();

        $interview = Interview::where([
            'id'=>$id,
            'user_id'=>$user->id,
        ])->latest()->first();

       $candidate =  $companyCandidates = CompanyCandidate::query()
       ->leftJoin('company_demands', 'company_demands.id', '=', 'company_candidates.demand_id')
       ->leftJoin('users as company_user', 'company_demands.company_id', '=', 'company_user.id')
       ->leftJoin('companies', 'companies.id', '=', 'company_candidates.company_id')
       ->leftJoin('users as candidates', 'candidates.id', '=', 'company_candidates.user_id')
       ->leftJoin('user_details as candidate_details', 'candidate_details.user_id', '=', 'candidates.id')
       ->leftJoin('user_information as candidate_information', 'candidate_information.user_id', '=', 'candidates.id')
       ->leftJoin('upload_photos', 'candidates.id', '=', 'upload_photos.user_id')
       ->where('company_candidates.user_id', $user->id)
       ->where('company_candidates.user_id', $user->id)
       ->leftJoin('interviews', function ($join) {
        $join->on('interviews.user_id', '=', 'candidates.id')
            ->on('interviews.demand_id', '=', 'company_candidates.demand_id');
        })
        ->where('interviews.id', $interview->id)
       ->orderBy('id', 'desc')
       ->select([
        'company_candidates.*',
        'companies.name as company_name',
        'companies.address as company_address',
        'companies.logo as company_logo',
        'companies.country as company_country',
        'company_user.id as company_user_id',

        'candidates.id as candidate_id',
        'candidates.email as candidate_email',

        'company_demands.demand_code as demand_demand_code',
        'company_demands.gender as demand_gender',
        'age_from',
        'age_to',
        'company_demands.height as demand_height',
        'company_demands.weight as demand_weight',
        'experience_year',
        'education',
        'edu_level',
        'demand_letter',
        'company_demands.status as demand_status',
       ])->first();


        $processes =[];
        $processes = [
            'company_info'=>[
                'id'=>$candidate->company_id,
                'company_name'=>$candidate->company_name,
                'company_logo'=>$candidate->company_logo,
                'company_address'=>$candidate->company_address,
                'company_country'=>Country::where('id', $candidate->company_country)->first()?->name,
            ],
            'demand_info'=>[
                'demand_code'=>$candidate->demand_code,
                'gender'=>$candidate->demand_gender,
                'age_from'=>$candidate->age_from,
                'age_to'=>$candidate->age_to,
                'height'=>$candidate->demand_height,
                'weight'=>$candidate->demand_weight,
                'experience_year'=>$candidate->experience_year,
                'education'=>$candidate->education,
                'edu_level'=>$candidate->edu_level,
                'demand_letter'=>$candidate->demand_letter,
                'demand_status'=>$candidate->demand_status,
            ],
        ];
            $steps = [];
            $steps[] = [
                'step'=>1,
                'message'=>'Wishlisted',
                'data'=>[],
            ];


            $interview = Interview::where([
                'demand_id'=>$candidate->demand_id,
                'user_id'=>$user->id,
            ])->latest()->first();

            if($interview){
                $steps[] = [
                    'step'=>2,
                    'message'=>'Interview Process Started',
                    'data'=>$interview,
                ];

                if($interview->user_accept_status == "Accepted" || $interview->user_accept_status=="Declined"){
                    $steps[] = [
                        'step'=>3,
                        'message'=>'Interview '.$interview->user_accept_status .' By You',
                        'data'=>$interview,
                    ];
                }
                if($interview->user_accept_status == "Accepted"){
                    if($interview->interview_date !== null && $interview->interview_date !== ''){
                        $steps[] = [
                            'step'=>4,
                            'message'=>'Interview Scheduled',
                            'data'=>$interview,
                        ];
                    }
                    if($interview->user_accept_status == "Accepted" && (bool)$interview->is_taken){
                        $steps[] = [
                            'step'=>5,
                            'message'=>'Interview Attended',
                            'data'=>$interview,
                        ];
                    }
    
    
    
                    if($interview->user_accept_status == "Accepted" && (bool)$interview->is_taken){
                        $message = "Rejected";
                        if((bool)$interview->is_selected){
                            $steps[] = [
                                'step'=>6,
                                'message'=>'Selected',
                                'data'=>$interview,
                            ];
                        }
                    }
    
    
    
                    if($interview->user_accept_status == "Accepted" && (bool)$interview->is_taken){
                        if((bool)$interview->is_selected){
                            $medicalCheckup = MedicalCheckup::where([
                                'company_id'=>$candidate->company_id,
                                'demand_id'=>$candidate->demand_id,
                                'user_id'=>$user->id,
                            ])->latest()->first();
                
                            if($medicalCheckup){
                                $steps[] = [
                                    'step'=>7,
                                    'message'=>'Medical Checkup Scheduled',
                                    'data'=>$medicalCheckup,
                                ];
                                if((bool)$medicalCheckup->is_tested){
                                    $steps[] = [
                                        'step'=>8,
                                        'message'=>'Medical Checkup Done',
                                        'data'=>$medicalCheckup,
                                    ];
    
                                    if($medicalCheckup->status == "Fit"){
                                        $documentProcess = DocumentProcess::where([
                                            'user_id'=>$candidate->user_id,
                                            'company_id'=>$candidate->company_id,
                                            'demand_id'=>$candidate->demand_id,
                                        ])->first();
                            
                                        if($documentProcess){
                                            $steps[] = [
                                                'step'=>9,
                                                'message'=>'Document Process Started',
                                                'data'=>$documentProcess,
                                            ];
                                        }
                            
                            
                                        if($documentProcess){
                                            if($documentProcess->status == "Completed"){
                                                $steps[] = [
                                                    'step'=>10,
                                                    'message'=>'Document Process Completed',
                                                    'data'=>$documentProcess,
                                                ];
    
    
                                                if($documentProcess->status == "Completed"){
                                                    $visaProcess = VisaProcess::where([
                                                        'user_id'=>$candidate->user_id,
                                                        'company_id'=>$candidate->company_id,
                                                        'demand_id'=>$candidate->demand_id,
                                                    ])->first();
                                        
                                        
                                                    if($visaProcess){
                                                        $steps[] = [
                                                            'step'=>11,
                                                            'message'=>'Visa Process Started',
                                                            'data'=>$visaProcess,
                                                        ];
    
    
                                                        $message = 'Visa Process '.$visaProcess->status;
                                                        $steps[] = [
                                                            'step'=>12,
                                                            'message'=>$message,
                                                            'data'=>$visaProcess,
                                                        ];
                                                        if($visaProcess->status == "Successed"){
                                                            $evisa = EVisaProcess::where([
                                                                'user_id'=>$candidate->user_id,
                                                                'company_id'=>$candidate->company_id,
                                                                'demand_id'=>$candidate->demand_id,
                                                            ])->first();
                                                
                                                            if($evisa){
                                                                $steps[] = [
                                                                    'step'=>13,
                                                                    'message'=>'E Visa Process Started',
                                                                    'data'=>$evisa,
                                                                ];
    
    
    
                                                                $message = 'E Visa Process '.$evisa->status;
                                                                $steps[] = [
                                                                    'step'=>14,
                                                                    'message'=>$message,
                                                                    'data'=>$evisa,
                                                                ];
                                                                if($evisa->status == "Successed"){
                                                                    $labourPermit = LabourPermit::where([
                                                                        'user_id'=>$candidate->user_id,
                                                                        'company_id'=>$candidate->company_id,
                                                                        'demand_id'=>$candidate->demand_id,
                                                                    ])->first();
                                                        
                                                        
                                                                    
                                                                    if($labourPermit){
                                                                        $steps[] = [
                                                                            'step'=>15,
                                                                            'message'=>'Permit Process Started',
                                                                            'data'=>$labourPermit,
                                                                        ];
    
                                                                        $message = 'Permit Process '.$labourPermit->status;
                                                                        $steps[] = [
                                                                            'step'=>16,
                                                                            'message'=>$message,
                                                                            'data'=>$evisa,
                                                                        ];
    
    
                                                                        if($labourPermit->status == "Successed"){
                                                                            $eticket = ETicketProcess::where([
                                                                                'user_id'=>$candidate->user_id,
                                                                                'company_id'=>$candidate->company_id,
                                                                                'demand_id'=>$candidate->demand_id,
                                                                            ])->first();
                                                                
                                                                
                                                                            if($eticket){
                                                                                $steps[] = [
                                                                                    'step'=>17,
                                                                                    'message'=>'Ticket Process Started',
                                                                                    'data'=>$eticket,
                                                                                ];
    
                                                                                $message = 'Ticket Process '.$eticket->status;
                                                                                $steps[] = [
                                                                                    'step'=>18,
                                                                                    'message'=>$message,
                                                                                    'data'=>$evisa,
                                                                                ];
    
                                                                                if($eticket->status == "Successed"){
                                                                                    $finaleJob = FinalJobstatus::where([
                                                                                        'user_id'=>$candidate->user_id,
                                                                                        'company_id'=>$candidate->company_id,
                                                                                        'demand_id'=>$candidate->demand_id,
                                                                                    ])->first();
                                                                        
                                                                                    if($finaleJob){
                                                                                        if((int)$finaleJob->status == 1){
                                                                                            $steps[] = [
                                                                                                'step'=>19,
                                                                                                'message'=>"Engaged On Job",
                                                                                                'data'=>$evisa,
                                                                                            ];
                                                                                        }
                                                                                    }
                                                                        
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
    
                                                            }
    
                                                        }
    
                                                    }
                                                }
                                            }
                                        }
                            
                                    }
                                }
    
                            }
                        }
                    } 
                }
            }
            $processes['steps'] = $steps;
       return response()->json([
            'success'=>true,
            'message'=>'Application Process',
            'data'=>$processes,
       ]);
    }
}
