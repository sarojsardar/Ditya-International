<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Enum\UserDemandStatus;
use App\Models\CompanyCandidate;
use App\Enum\UserInterviewStatus;
use App\Action\NotificationAction;
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
        $companyCandidates = CompanyCandidate::with(['company'])
            ->where('user_id', $userID)
            ->where('demand_status', UserDemandStatus::Approved)
            ->where('interview_status', UserInterviewStatus::Pending)
            ->get();

        // Extract only the company data from the retrieved records
        $companyData = $companyCandidates->map(function ($companyCandidate) {
            return $companyCandidate->company; // Assuming 'company' is not null
        });

        return response()->json([
            'success' => true,
            'data' => $companyData,
        ]);
    }



    public function updateStatus(Request $request, $company_id)
    {
            $user = auth()->user();
            // the company_id is the user id of the company it may be change if required(this is written due to the demand company id is the user id not the company id)
            $companyDemand = CompanyDemand::where('company_id', $company_id)->whereIn('status', ['Open', 'Pending'])->latest()->first();
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
