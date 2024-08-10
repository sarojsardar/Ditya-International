<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Enum\UserDemandStatus;
use App\Models\CompanyCandidate;
use App\Enum\UserInterviewStatus;
use App\Action\NotificationAction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;

class InterviewController extends Controller
{
    //
    public function selectedByCompany()
    {
        // Retrieve the authenticated user's ID
        $userID = auth()->id();


        // Retrieving all CompanyCandidate records associated with the authenticated user's ID
        $companyCandidates = CompanyCandidate::where('user_id', $userID)
            ->with('company')
            ->where('demand_status', UserDemandStatus::Approved)
            ->get(); // Retrieve all matching CompanyCandidate records


        if (!$companyCandidates) {
            // If the user is not approved, return count as 0
            return response()->json([
                'success' => true,
                'companyCount' => 0,
            ]);
        }


        // Count the number of CompanyCandidate records
        $count = $companyCandidates->count();

        // Return the count in a JSON response
        return response()->json([
            'success' => true,
            'companyCount' => $count,
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
            ->where(DB::raw("CONCAT(interview_date, ' ', interview_time)"), '>=', $now)

            ->where('company_candidates.demand_status', UserDemandStatus::Approved)
            ->where('company_candidates.interview_status', UserInterviewStatus::Pending)
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







}
