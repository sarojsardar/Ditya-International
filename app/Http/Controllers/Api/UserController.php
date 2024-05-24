<?php

namespace App\Http\Controllers\Api;

use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\CategoryDetail;
use App\Models\EducationalDocument;
use App\Models\EducationType;
use App\Models\LanguageDetail;
use App\Models\PassportDetail;
use App\Models\ResumeDetail;
use App\Models\UploadPhoto;
use App\Models\UserDetail;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function updateUserDetails(Request $request) {
        // Enhanced validation rules
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'temporary_address' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'marital_status' => 'required|string',
            'spouse_name' => 'nullable|string|max:255|required_if:marital_status,Married,Unmarried',
            'gender' => 'required|string|in:male,female',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'dob' => 'required|date',
            'has_relatives_in_malaysia' => 'required|boolean',
            'has_been_in_accident' => 'required|boolean',
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $user = Auth::user();

        try {
            // Calculate age from DOB
            $dob = Carbon::parse($validatedData['dob']);
            $age = $dob->age; // This calculates the age based on the DOB

         //   dd($age);

            $userDetail = UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $validatedData['full_name'],
                    'permanent_address' => $validatedData['permanent_address'],
                    'temporary_address' => $validatedData['temporary_address'],
                    'father_name' => $validatedData['father_name'],
                    'mother_name' => $validatedData['mother_name'],
                    'marital_status' => $validatedData['marital_status'],
                    'spouse_name' => $validatedData['marital_status'] === 'Married' ? $validatedData['spouse_name'] : null,
                    'gender' => $validatedData['gender'],
                    'height' => $validatedData['height'],
                    'weight' => $validatedData['weight'],
                    'dob' => $validatedData['dob'],
                    'age' => $age, // Store the calculated age
                    'has_relatives_in_malaysia' => $validatedData['has_relatives_in_malaysia'],
                    'has_been_in_accident' => $validatedData['has_been_in_accident'],

                ]
            );

            $action = $userDetail->wasRecentlyCreated ? 'created' : 'updated';
            return response()->json(['message' => "User details $action successfully",'status' => true,]);
        } catch (\Exception $e) {
            return response()->json([ 'message' => 'Failed to update user details', 'error' => $e->getMessage()], 500);
        }
    }

    public function uploadPhoto(Request $request)
    {
        // Validate the request data if needed
        $request->validate([
            'passport_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'full_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Update or create user details
        $userDetail = UploadPhoto::updateOrCreate(
            ['user_id' => $userId],

        );



        // Validate and handle passport photo upload
        if ($request->hasFile('passport_photo')) {
            $passportPhotoFile = $request->file('passport_photo');
            $passportPhotoName = pathinfo($passportPhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $passportPhotoPath = (new ImageUploadHelper())->uploadImage($passportPhotoFile, 'public/uploads/passport-photos', $passportPhotoName);

            $userDetail->passport_photo = $passportPhotoPath;
        }

        // Validate and handle full photo upload
        if ($request->hasFile('full_photo')) {
            $fullPhotoFile = $request->file('full_photo');
            $fullPhotoName = pathinfo($fullPhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $fullPhotoPath = (new ImageUploadHelper())->uploadImage($fullPhotoFile, 'public/uploads/full-photos', $fullPhotoName);

            $userDetail->full_photo = $fullPhotoPath;
        }

        // Save the changes to the UserDetail model
        $userDetail->save();

        return response()->json(['status' => true, 'message' => 'Photos updated successfully.'], 200);

    }

    public function updatePassportDetails(Request $request){
        // Validate the request data if needed
        $request->validate([
            'passport_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'passport_number' => 'required',
            'expiry_date' => 'required',
            'issue_place' => 'required',
            'passport_issue_date' => 'required',

        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Update or create user details
        $userDetail = PassportDetail::updateOrCreate(
            ['user_id' => $userId],
            [
                'passport_number' => $request->passport_number,
                'expiry_date' => $request->expiry_date,
                'issue_place' => $request->issue_place,
                'passport_issue_date' => $request->passport_issue_date,
            ]

        );

        // Validate and handle passport photo upload
        if ($request->hasFile('passport_image')) {
            $passportImageFile = $request->file('passport_image'); // Corrected variable name
            $passportImageName = pathinfo($passportImageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $passportImagePath = (new ImageUploadHelper())->uploadImage($passportImageFile, 'public/uploads/passport-images', $passportImageName);

            $userDetail->passport_image = $passportImagePath; // Corrected field name
        }

        // Save the changes to the UserDetail model
        $userDetail->save();

        return response()->json(['status' => true, 'message' => 'Passport Details Updated Successfully']);
    }

    public function updateResumeDetails(Request $request)
    {
        // Validate the request data if needed
        $request->validate([
            'resume_file' => 'required|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Update or create user details
        $userDetail = ResumeDetail::updateOrCreate(
            ['user_id' => $userId],
            [] // Add any other fields that you want to update or create
        );

        // Validate and handle resume file upload
        if ($request->hasFile('resume_file')) {
            $resumeFile = $request->file('resume_file');
            $resumeName = pathinfo($resumeFile->getClientOriginalName(), PATHINFO_FILENAME);
            $resumeFilePath = (new ImageUploadHelper())->uploadImage($resumeFile, 'public/uploads/resume-files', $resumeName);

            $userDetail->resume_file = $resumeFilePath; // Corrected field name
        }

        // Save the changes to the ResumeDetail model
        $userDetail->save();

        return response()->json(['status' => true, 'message' => 'Resume Details Updated Successfully']);
    }

    public function updateEducationalDetails(Request $request)
    {
        // Validate the request data
        $request->validate([
            'edu_doc' => 'required|mimes:jpeg,png,jpg,pdf|max:4096', // Assuming single file, not an array
            'level' => 'required',
            'edu_level' => 'required',
            'school_college_name' => 'required',
            'pass_year' => 'required'
        ]);

        $user = Auth::user();
        $userId = $user->id;
        $educationType = EducationType::where('name', $request->level)->first();

        // Handle the educational document upload
        $eduDocFile = $request->file('edu_doc');
        if ($eduDocFile && $eduDocFile->isValid()) {
            $eduDocName = pathinfo($eduDocFile->getClientOriginalName(), PATHINFO_FILENAME);
            $eduDocPath = (new ImageUploadHelper())->uploadImage($eduDocFile, 'public/uploads/edu-doc', $eduDocName);

            // Update or create user educational detail
            EducationalDocument::updateOrCreate(
                [
                    'user_id' => $userId,
                    'level' => $request->level,
                    'edu_level' => $educationType->edu_level,
                    'school_college_name' => $request->school_college_name,
                    'pass_year' => $request->pass_year,
                ],
                ['edu_doc' => $eduDocPath]
            );
        }

        return response()->json(['status' => true, 'message' => 'Educational detail updated successfully']);
    }


    public function updateWorkDetails(Request $request) {
        // Validate the request data if needed
        $request->validate([
            'address.*' => 'required',
            'company_name.*' => 'required',
            'position.*' => 'required',
            'description.*' => 'required',
            'country.*' => 'required',
            'no_of_years.*' => 'required',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Loop through each work experience in the request
        foreach ($request->input('address') as $key => $address) {
            // Update or create work experience details for each entry
            WorkExperience::updateOrCreate(
                [
                    'user_id' => $userId,
                    'address' => $address,
                    'company_name' => $request->input('company_name')[$key],
                    'position' => $request->input('position')[$key],
                    'country' => $request->input('country')[$key],
                    'no_of_years' => $request->input('no_of_years')[$key],
                ],
                ['description' => $request->input('description')[$key]]
            );
        }

        // Calculate the total number of years from the request
        $totalYears = array_sum($request->input('no_of_years'));

        // Update the user model with the total years of experience
        $user->total_work_experience = $totalYears;
        $user->save();

        return response()->json(['status' => true, 'message' => 'Work experiences updated successfully']);
    }




    public function updateLanguageDetails(Request $request)
    {
        // Validate the request data if needed
        $request->validate([
            'language_name.*' => 'required',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Loop through each language in the request
        foreach ($request->input('language_name') as $languageName) {
            // Update or create user details for each language
            LanguageDetail::updateOrCreate(
                ['user_id' => $userId,
                'language_name' => $languageName],
            );
        }

        return response()->json(['status' => true, 'message' => 'Language details updated successfully']);
    }



    public function updateCategoryDetails(Request $request)
    {
        // Validate the request data if needed
        $request->validate([
            'category_id.*' => 'required',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Loop through each Category in the request
        foreach ($request->input('category_id') as $categoryName) {
            // Update or create user details for each Category
            CategoryDetail::updateOrCreate(
                ['user_id' => $userId, 'category_id' => $categoryName],
                ['category_id' => $categoryName]
            );
        }

        return response()->json(['status' => true, 'message' => 'Category details updated successfully']);
    }


    public function updateBankDetails(Request $request){
        // Validate the request data if needed
        $request->validate([
            'bank_name' => 'required',
            'branch' => 'required',
            'account_holder_name' => 'required',
            'account_no' => 'required'

        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Update or create user details
        $userDetail = BankDetail::updateOrCreate(
            ['user_id' => $userId],
            [
                'bank_name' => $request->bank_name,
                'branch' => $request->branch,
                'account_holder_name' => $request->account_holder_name,
                'account_no' => $request->account_no,
            ]

        );


        return response()->json(['status' => true, 'message' => 'Bank Details Updated Successfully']);

    }
}
