<?php

namespace App\Http\Controllers\Api;

use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EducationalDocumentResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\WorkExperienceResource;
use App\Models\BankDetail;
use App\Models\CategoryDetail;
use App\Models\EducationalDocument;
use App\Models\LanguageDetail;
use App\Models\PassportDetail;
use App\Models\ResumeDetail;
use App\Models\UploadPhoto;
use App\Models\UserDetail;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStepController extends Controller
{
    public function checkUserDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user
        $userId = $user->id; // Get the user's ID

        // Retrieve the user's details
        $userDetails = UserDetail::where('user_id', $userId)->first();

        // Initialize the required details array
        $requiredDetails = [
            'full_name', 'permanent_address', 'temporary_address',
            'father_name', 'mother_name', 'marital_status', 'gender', 'height', 'weight', 'dob'
        ];
        

        // Initialize an array for missing details
        $missingDetails = [];

        // If userDetails is null, we consider all details missing
        if (!$userDetails) {
            return response()->json([
                'errors' => 'No user details found.',
                'step' => 1,
                'status' => false,
                'missing_details' => $requiredDetails
            ]);
        }

        // Check each required detail
        foreach ($requiredDetails as $detail) {
            if (empty($userDetails->$detail)) {
                $missingDetails[] = $detail;
            }
        }

        // Construct the response based on whether any details are missing
        if (empty($missingDetails)) {
            // Construct the data array only if all details are present
            $data = [
                'full_name' => $userDetails->full_name,
                'permanent_address' => $userDetails->permanent_address,
                'temporary_address' => $userDetails->temporary_address,
                'dob' => $userDetails->dob,
                'height' => $userDetails->height,
                'weight' => $userDetails->weight,
                'father_name' => $userDetails->father_name,
                'mother_name' => $userDetails->mother_name,
                'marital_status' => $userDetails->marital_status,
                'spouse_name' => $userDetails->spouse_name,
                'gender' => $userDetails->gender,
            ];

            return response()->json([
                'data' => $data,
                'message' => 'All user details are filled',
                'step' => 1,
                'status' => true
            ]);
        } else {
            return response()->json([
                'errors' => 'Some user details are missing',
                'step' => 1,
                'status' => false,
                'missing_details' => $missingDetails
            ]);
        }
    }

    public function checkPhotoDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve the user's photo details
        $userPhotoDetails = UploadPhoto::where('user_id', $user->id)->first();

        // Initialize the data array with null values as defaults
        $data = [
            'passport_photo' => null,
            'full_photo' => null,
        ];

        // Initialize an array to hold the fields that are missing
        $missingDetails = ['passport_photo', 'full_photo']; // Assume both are missing initially

        if ($userPhotoDetails) {
            // Update data with actual values if they exist
            $data['passport_photo'] = $userPhotoDetails->passport_photo ?  url('/storage/uploads/passport-photos/'.$userPhotoDetails->passport_photo) : null;
            $data['full_photo'] = $userPhotoDetails->full_photo ? asset('storage/uploads/full-photos/'.$userPhotoDetails->full_photo) : null;

            // Remove from missing details if present
            if (!empty($userPhotoDetails->passport_photo)) {
                unset($missingDetails[array_search('passport_photo', $missingDetails)]);
            }

            if (!empty($userPhotoDetails->full_photo)) {
                unset($missingDetails[array_search('full_photo', $missingDetails)]);
            }
        }

        // Reindex array to ensure consecutive keys
        $missingDetails = array_values($missingDetails);

        if (empty($missingDetails)) {
            return response()->json([
                'data' => $data,
                'message' => 'All photo details are filled',
                'step' => 2,
                'status' => true,
            ]);
        } else {
            return response()->json([
                'errors' => 'Some photo details are missing',
                'step' => 2,
                'status' => false,
                'missing_details' => $missingDetails
            ]);
        }
    }


    public function checkPassportDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve the user's passport details
        $passportDetails = PassportDetail::where('user_id', $user->id)->first();

        // Initialize data array with null values as default
        $data = [
            'passport_image' => null,
            'passport_number' => null,
            'passport_issue_date' => null,
            'expiry_date' => null,
            'issue_place' => null,
        ];

        // Define the required passport details fields
        $requiredDetails = [
            'passport_number', 'expiry_date', 'issue_place', 'passport_issue_date', 'passport_image'
        ];

        // Initialize an array to hold the fields that are missing
        $missingDetails = [];

        if ($passportDetails) {
            // Populate the data array with existing details
            $data = [
                'passport_image' => $passportDetails->passport_image ? asset('storage/uploads/passport-images/'.$passportDetails->passport_image) : null,
                'passport_number' => $passportDetails->passport_number,
                'passport_issue_date' => $passportDetails->passport_issue_date,
                'expiry_date' => $passportDetails->expiry_date,
                'issue_place' => $passportDetails->issue_place,
            ];

            // Check each required detail for emptiness
            foreach ($requiredDetails as $detail) {
                if (empty($passportDetails->$detail)) {
                    $missingDetails[] = $detail;
                }
            }
        } else {
            // If no passport details are found, all defined details are considered missing
            $missingDetails = $requiredDetails;
        }

        // Prepare the response based on whether any details are missing
        if (empty($missingDetails)) {
            return response()->json([
                'data' => $data,
                'message' => 'All passport details are filled',
                'step' => 3,
                'status' => true,
            ]);
        } else {
            return response()->json([
                'errors' => 'Some passport details are missing',
                'missing_details' => $missingDetails,
                'step' => 3,
                'status' => false,
            ]);
        }
    }


    public function checkResumeDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve the user's resume details
        $userResumeDetail = ResumeDetail::where('user_id', $user->id)->first();

        // Check if the ResumeDetail exists and the resume file is present
        if ($userResumeDetail && $userResumeDetail->resume_file) {
            // Construct the file path using Laravel's asset helper
            $filePath = asset('storage/uploads/resume-files/'.$userResumeDetail->resume_file);

            // Return success response with the resume file path
            return response()->json([
                'data' => ['resume_file' => $filePath],
                'message' => 'Resume details are filled',
                'status' => true,
                'step' => 4,
            ]);
        }

        // Return error response if ResumeDetail doesn't exist or the resume_file is empty
        return response()->json([
            'errors' => 'Resume details are missing or the file is not uploaded',
            'step' => 4,
            'status' => false
        ]);
    }



    public function checkEducationalDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user
        $userId = $user->id; // Get the user's ID

        // Retrieve all educational records for the user
        $educationalDetails = EducationalDocument::where('user_id', $userId)->get();

        // If no educational records are found, return a message indicating that
        if ($educationalDetails->isEmpty()) {
            return response()->json([
                'message' => 'No educational details found for the user',
                'status' => false,
                'step' => 5,
            ]);
        }

        // Initialize an array to hold the completeness status of each record
        $completenessStatus = [];

        // Define the fields that are required
        $requiredFields = ['edu_doc', 'level', 'school_college_name', 'pass_year'];

        // Check each educational record for completeness
        foreach ($educationalDetails as $detail) {
            $missingFields = [];
            foreach ($requiredFields as $field) {
                // Check if any of the required fields are missing or empty
                if (empty($detail->$field)) {
                    $missingFields[] = $field;
                }
            }
            $completenessStatus[] = [
                'record_id' => $detail->id,
                'is_complete' => empty($missingFields),
                'missing_fields' => $missingFields,
            ];
        }

        // Check if all records are complete
        $allComplete = true;
        foreach ($completenessStatus as $status) {
            if (!$status['is_complete']) {
                $allComplete = false;
                break;
            }
        }

        // Return a response based on the completeness of all records
        if ($allComplete) {
            return response()->json([
                'data' => EducationalDocumentResource::collection($educationalDetails),
                'message' => 'All educational details are complete',
                'step' => 5,
                'status' => true,
            ]);
        } else {
            return response()->json([
                'errors' => 'Some educational details are missing or incomplete',
                'step' => 5,
                'status' => false,
                'incomplete_records' => $completenessStatus,
            ]);
        }
    }

    public function checkLanguageDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user
        $userId = $user->id; // Get the user's ID

        // Retrieve the user's language details
        $userLanguageDetails = LanguageDetail::where('user_id', $userId)->get();

        if ($userLanguageDetails->isEmpty()) {
            // If no language details are found, return a message indicating that language details are missing
            return response()->json([
                'message' => 'Language details are missing',
                'step' => 6,
                'status' => false,
            ]);
        } else {
            // If language details are found, return a message indicating that language details are filled
            return response()->json([
                'data' => $userLanguageDetails->pluck('language_name'),
                'message' => 'Language details are filled',
                'step' => 6,
                'status' => true,

            ]);
        }
    }



    public function checkWorkDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user
        $userId = $user->id; // Get the user's ID

        // Retrieve the user's work experience records
        $workExperiences = WorkExperience::where('user_id', $userId)->get();
        $data = WorkExperienceResource::collection($workExperiences);

        if ($workExperiences->isEmpty()) {
            // No work experience records found
            return response()->json([
                'errors' => 'No work experience details found. Please add work experience details.',
                'status' => false,
                'step' => 7,
                ]);
        }

        $incompleteDetails = [];

        // Loop through each work experience record to check for completeness
        foreach ($workExperiences as $workExperience) {
            $missingFields = [];

            // Check each required field
            if (empty($workExperience->address)) $missingFields[] = 'address';
            if (empty($workExperience->company_name)) $missingFields[] = 'company_name';
            if (empty($workExperience->position)) $missingFields[] = 'position';
            if (empty($workExperience->description)) $missingFields[] = 'description';
            if (empty($workExperience->country)) $missingFields[] = 'country';
            if (empty($workExperience->no_of_years)) $missingFields[] = 'no_of_years';

            // If there are missing fields for a record, add it to the incompleteDetails array
            if (!empty($missingFields)) {
                $incompleteDetails[] = [
                    'work_experience_id' => $workExperience->id,
                    'missing_fields' => $missingFields
                ];
            }
        }

        if (empty($incompleteDetails)) {
            return response()->json([
                'data' => $data,
                'message' => 'All work experience details are complete.',
                'step' => 7,
                'status' => true,
                ]);
        } else {
            return response()->json([
                'errors' => 'Some work experience details are incomplete.',
                'step' => 7,
                'status' => false,
                'incomplete_details' => $incompleteDetails
            ]);
        }
    }

    public function checkBankDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve the user's bank details
        $userBankDetails = BankDetail::where('user_id', $user->id)->first();

        if (!$userBankDetails) {
            // If no bank details are found, consider all required details as missing
            return response()->json([
                'message' => 'Bank details are missing',
                'step' => 8,
                'status' => false,
                'missing_details' => ['bank_name', 'branch', 'account_holder_name', 'account_no']
            ]);
        }

        // Initialize an array to hold fields that are missing
        $missingDetails = [];

        // Define the required bank details fields
        $requiredFields = ['bank_name', 'branch', 'account_holder_name', 'account_no'];

        foreach ($requiredFields as $field) {
            if (empty($userBankDetails->$field)) {
                $missingDetails[] = $field; // If the field is empty, add it to the missingDetails array
            }
        }

        if (empty($missingDetails)) {
            // Prepare the data for response if no details are missing
            $data = [
                'bank_name' => $userBankDetails->bank_name,
                'branch' => $userBankDetails->branch,
                'account_holder_name' => $userBankDetails->account_holder_name,
                'account_no' => $userBankDetails->account_no,
            ];

            return response()->json([
                'data' => $data,
                'message' => 'All bank details are filled',
                'step' => 8,
                'status' => true
            ]);
        } else {
            // If some details are missing, inform the user which details need to be filled
            return response()->json([
                'message' => 'Some bank details are missing',
                'step' => 8,
                'status' => false,
                'missing_details' => $missingDetails
            ]);
        }
    }



    public function checkCategoryDetailsFilled() {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve the user's category details
        $userCategoryDetails = CategoryDetail::where('user_id', $user->id)->get();

        if ($userCategoryDetails->isEmpty()) {
            // No category details found for the user
            return response()->json([
                'message' => 'Category details are missing',
                'step' => 9,
                'status' => false,
            ]);
        }

        // Initialize an array to hold any categories that might be missing essential information
        $categoriesMissingName = [];

        foreach ($userCategoryDetails as $detail) {
            if (empty($detail->category_id)) {
                // If the category name is empty, add its ID to the array
                $categoriesMissingName[] = $detail->id;
            }
        }

        if (empty($categoriesMissingName)) {
            // All category details are filled
            return response()->json([
                'data' => $userCategoryDetails->pluck('category_id'),
                'message' => 'All category details are filled',
                'step' => 9,
                'status' => true,
            ]);
        } else {
            // Some categories are missing names
            return response()->json([
                'message' => 'Some categories are missing names',
                'missing_categories' => $categoriesMissingName,
                'step' => 9,
                'status' => false,
            ]);
        }
    }


    public function checkAllDetailsFilled() {
        $userId = Auth::id(); // Assuming Auth::id() gives the user's ID

        // Initialize response structure
        $response = [
            'status' => true,
            'steps' => [],
            'firstIncompleteStep' => null,
        ];

        // List of functions to be checked
        $checkFunctions = [
            'checkUserDetailsFilled',
            'checkPhotoDetailsFilled',
            'checkPassportDetailsFilled',
            'checkResumeDetailsFilled',
            'checkEducationalDetailsFilled',
            'checkLanguageDetailsFilled',
            'checkWorkDetailsFilled',
            'checkBankDetailsFilled',
            'checkCategoryDetailsFilled',
        ];

        foreach ($checkFunctions as $function) {
            try {
                $result = $this->$function($userId); // Assuming each function accepts userId as a parameter
                $data = json_decode($result->getContent(), true);

                // Capture each step's details in the response
                $response['steps'][] = [
                    'step' => $data['step'] ?? null,
                    'status' => $data['status'] ?? false,
                    'message' => $data['message'] ?? '',
                    'data' => $data['data'] ?? [],
                    'missing_details' => $data['missing_details'] ?? [],
                    'errors' => $data['errors'] ?? null,
                ];

                // Identify the first highest step with a false status
                if (($data['status'] ?? false) === false && is_null($response['firstIncompleteStep'])) {
                    $response['firstIncompleteStep'] = $data['step'] ?? null;
                    $response['status'] = false;
                    break; // Stop the loop once the first incomplete step is found
                }
            } catch (\Exception $e) {
                // Handle any errors from the check functions gracefully
                return response()->json([
                    'status' => false,
                    'error' => 'An unexpected error occurred during the checks.',
                    'exception' => $e->getMessage(), // Consider for debugging, remove or hide in production
                ]);
            }
        }

        // Return the enhanced response
        return response()->json($response);
    }


}
