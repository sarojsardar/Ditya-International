<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserDemandStatus;
use App\Enum\UserInterviewStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\CompanyCandidate;
use App\Models\User;
use Illuminate\Http\Request;

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



    public function updateStatus(Request $request, $id)
    {
            // Validate the request data
            $validatedData = $request->validate([
                'interview_status' => 'required', // Adjust validation rules as needed
            ]);

            // Find the CompanyCandidate by user_id, throw a ModelNotFoundException if not found
            $companyCandidate = CompanyCandidate::where('user_id', $id)->firstOrFail();

            // Update the CompanyCandidate's interview status
            $companyCandidate->interview_status = $validatedData['interview_status'];
            $companyCandidate->demand_status = UserDemandStatus::Interview;
            $companyCandidate->save();

            // Return a successful response
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ], 200);

    }







}
