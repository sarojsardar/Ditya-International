<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Enum\UserTypes;
use App\Models\Company;
use App\Models\Language;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Models\EducationType;
use App\Enum\UserDemandStatus;
use App\Models\CompanyCandidate;
use App\Data\company\CompanyData;
use App\Enum\UserInterviewStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Data\Candidate\CandidateData;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\DemandNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CandidateController extends Controller
{

    public function index(Request $request){

        // Fetch the demand by demandCode
        $demand = CompanyDemand::first();

        // Proceed only if demand is found
        if (!$demand) {
            // Handle the case where the demand is not found
            abort(404, 'Demand not found');
        }

        $demands = User::where('user_type', '=', UserTypes::CANDIDATE)
            ->whereHas('userDetail', function ($query) use ($demand) {
                $query->where('gender', $demand->gender)
                    ->where('height', '>=', $demand->height)
                    ->where('weight', '>=', $demand->weight)
                    ->where('total_work_experience', '>=', $demand->experience_year)
                    ->whereBetween('age', [$demand->age_from, $demand->age_to]); // Filter by DOB within the specified age range in the user details
            })
            ->get();

        if($request->ajax()){
            return DataTables::of($demands)
                ->addIndexColumn()
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })
                ->addColumn('total_work_experience', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return $row->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })

                ->addColumn('action', function($row){
                    $infoUrl = route('candidate.detail', $row->id);
                    return "<div>
                    <a href='$infoUrl' target='_blank' title='Info'><button class='btn btn-sm btn-secondary'><i class='fas fa-info'></i>Form</button></a>
                     <button class='btn btn-sm btn-primary' onclick='viewAdditionalDocument({$row->id});'><i class='fab fa-wpforms'></i> View Documents</button>
                    </div>";

                })

                ->rawColumns(['DT_RowIndex', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight'])
                ->make(true);
        }


    }


    public function demandCandidates(Request $request, $demandCode){

        $authUserId = auth('web')->user()->id; // Get the authenticated user's ID

        // Fetch the demand by demandCode and ensure it's pending
        $demand = CompanyDemand::where('demand_code', $demandCode)
            ->where('company_id', $authUserId)
            ->first();

            
        if (!$demand) {
            if ($request->ajax()) {
                // For AJAX requests, return an empty set to DataTables
                return DataTables::of([])->make(true);
            }
        }

        // Get the language IDs required by the company's demands
        $languageIds = CompanyDemand::where('demand_code', $demandCode)
            ->with('languages')
            ->get()
            ->pluck('languages.*.id')
            ->collapse() // Flatten the collection
            ->unique() // Ensure unique language IDs
            ->all();


        $authUser = auth()->user();
        if ($authUser && $authUser->companyInfo) {
            $authCompanyId = $authUser->companyInfo->id;
            $desiredStatuses = [UserDemandStatus::New, UserDemandStatus::Pending, UserDemandStatus::Rejected];

            $demands = User::where('user_type', UserTypes::CANDIDATE)
                ->whereIn('demand_status', $desiredStatuses)
                ->whereDoesntHave('candidateCompany', function ($query) use ($authCompanyId) {
                    // Exclude candidates associated with $authCompanyId
                    $query->where('company_id', $authCompanyId);
                })
                ->whereHas('userDetail', function ($query) use ($demand) {
                    if ($demand->gender !== 'both') {
                        $query->where('gender', $demand->gender);
                    }
                    $query->where('height', '>=', $demand->height)
                        ->where('weight', '>=', $demand->weight)
                        ->where('total_work_experience', '>=', $demand->experience_year)
                        ->whereBetween('age', [$demand->age_from, $demand->age_to]);
                })
                ->when(($demand->edu_level > 0), function($query) use($demand){
                    $query->whereHas('educations', function ($query) use ($demand) {
                        $query->where('edu_level', '>=', $demand->edu_level);
                    });
                })
                ->get();
        } else {
            // Handle cases where the auth user or their company info is not available
            // For example, return an empty collection or null
            $demands = collect(); // or null, based on how you want to handle this scenario
        }




        $userId = $authUserId;

        $requiredCategoryIds = DB::table('category_company')->where('user_id', $userId)->pluck('category_id')->toArray();
        $filteredUsers = $demands->filter(function ($user) use ($languageIds, $requiredCategoryIds) {
            // new updated to get language id not the id of the language detail
            $userLanguageIds = ($user->manyLanguages) ? (count($user->manyLanguages) > 0 ? ($user->manyLanguages->pluck('id')->all()) : []) : [];
            $userCategoryIds = DB::table('category_details')
                ->where('user_id', $user->id) // Assuming each user has a unique 'id'
                ->pluck('category_id')
                ->toArray();

                
            // Ensuring the user knows all required languages
            $languageCheck = !array_diff($languageIds, $userLanguageIds);
            // Checking for at least one matching category between the user's and the demand's
            $matchingCategories = array_intersect($requiredCategoryIds, $userCategoryIds);
            $categoryCheck = !empty($matchingCategories); // True if there's at least one match

            // Include users who pass both checks
            return $languageCheck && $categoryCheck;
        });

        session(['currentDemand' => $demand]);

        if($request->ajax()){
            return DataTables::of($filteredUsers)
                ->addIndexColumn()
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })
                ->addColumn('action', function($row) {
                    // Assuming you have a demand ID in your session
                    $demandId = session('currentDemand')->id ?? null; // Use a null coalescing operator as a fallback

                    $infoUrl = route('user.detail', ['id' => $row->id, 'demandId' => $demandId]);
                    $printUrl = route('candidate.printCandidateApplication', ['id' => $row->id]);

                    return "<div>
                    <a href='{$printUrl}' target='_blank' title='Print'><button class='btn btn-sm btn-secondary'><i class='mdi mdi-cloud-print'></i></button></a>
                    <a href='{$infoUrl}' title='Details'><button class='btn btn-sm btn-primary'><i class='mdi mdi-information-outline'></i></button></a>
                </div>";
                })

                ->rawColumns(['DT_RowIndex', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight'])
                ->make(true);
               }
                 return view('backend.pages.all-demands.index', [
                     'demands' => $demands,
                     'currentDemand' => session('currentDemand')
                 ]);

    }

    public function approvedDemandCandidates(Request $request, $demandCode){

        $authUserId = auth('web')->user()->id;

            $demand = CompanyDemand::where('demand_code', $demandCode)
                ->where('company_id', $authUserId);
            $demand->whereIn('status', ['Open', 'Pending']);
            $demand = $demand->latest()->first();

        if (!$demand) {
            if ($request->ajax()) {
                return DataTables::of([])->make(true);
            }
        }

        $languageIds = CompanyDemand::where('demand_code', $demandCode)
            ->with('languages')
            ->get()
            ->pluck('languages.*.id')
            ->collapse() // Flatten the collection
            ->unique() // Ensure unique language IDs
            ->all();


        $authUser = auth()->user();
        if ($authUser && $authUser->companyInfo) {
            $authCompanyId = $authUser->companyInfo->id;
            $company = Company::where('id', $authCompanyId)->first();
            
            $demands = User::where('user_type', UserTypes::CANDIDATE)
                ->whereHas('candidateCompany', function ($query) use($authCompanyId, $demand) {
                    $query->where('demand_status', UserDemandStatus::Approved);
                    $query->where('company_id', $authCompanyId);
                    $query->where('demand_id', $demand->id);
                })
                ->whereHas('userDetail', function ($query) use ($demand) {
                    if ($demand->gender !== 'both') {
                        $query->where('gender', $demand->gender);
                    }
                    $query->where('height', '>=', $demand->height)
                        ->where('weight', '>=', $demand->weight)
                        ->where('total_work_experience', '>=', $demand->experience_year)
                        ->whereBetween('age', [$demand->age_from, $demand->age_to]);
                })
                ->whereHas('educations', function ($query) use ($demand) {
                    $query->where('edu_level', '>=', $demand->edu_level);
                })
                // ->whereHas('interviews', function (Builder $query) use ($demand) {
                //     $query->whereColumn('interviews.user_id', 'users.id')
                //           ->where('interviews.demand_id', $demand->id);
                // })
                ->get();
        } else {
            // Handle cases where the auth user or their company info is not available
            // For example, return an empty collection or null
            $demands = collect(); // or null, based on how you want to handle this scenario
        }



        $userId = $authUserId;

        $requiredCategoryIds = DB::table('category_company')->where('user_id', $userId)->pluck('category_id')->toArray();

        $filteredUsers = $demands->filter(function ($user) use ($languageIds, $requiredCategoryIds) {
            $userLanguageIds = ($user->manyLanguages) ? (count($user->manyLanguages) > 0 ? ($user->manyLanguages->pluck('id')->all()) : []) : [];

            $userCategoryIds = DB::table('category_details')
                ->where('user_id', $user->id) // Assuming each user has a unique 'id'
                ->pluck('category_id')
                ->toArray();

            // Ensuring the user knows all required languages
            $languageCheck = !array_diff($languageIds, $userLanguageIds);

            // Checking for at least one matching category between the user's and the demand's
            $matchingCategories = array_intersect($requiredCategoryIds, $userCategoryIds);
            $categoryCheck = !empty($matchingCategories); // True if there's at least one match

            // Include users who pass both checks
            return $languageCheck && $categoryCheck;
        });

        session(['currentDemand' => $demand]);

        if($request->ajax()){
            return DataTables::of($filteredUsers)
                ->addIndexColumn()
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })
                ->addColumn('demand_status', function($row) use($company, $demand) {
                    // Ensure the demand_status is fetched; you might need to adjust this depending on your model structure
                    return $row->candidateCompany()->where([
                        'company_id'=>$company?->id,
                        'demand_id'=>$demand->id,
                    ])->latest()->first()?->demand_status ?? 'N/A'; // Assuming candidateCompany is the relationship name
                })
                ->addColumn('action', function($row) {
                    // Assuming you have a demand ID in your session
                    $demandId = session('currentDemand')->id ?? null; // Use a null coalescing operator as a fallback

                    $infoUrl = route('user.detail', ['id' => $row->id, 'demandId' => $demandId]);
                    $printUrl = route('candidate.printCandidateApplication', ['id' => $row->id]);

                    return "<div>
                    <a href='{$printUrl}' target='_blank' title='Print'><button class='btn btn-sm btn-secondary'><i class='mdi mdi-cloud-print'></i></button></a>
                    <a href='{$infoUrl}' title='Details'><button class='btn btn-sm btn-primary'><i class='mdi mdi-information-outline'></i></button></a>
                </div>";
                })

                ->rawColumns(['DT_RowIndex', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight','demand_status'])
                ->make(true);
        }
        return view('backend.pages.all-demands.index', [
            'demands' => $demands,
            'currentDemand' => session('currentDemand')
        ]);

    }


    public function interviewDemandCandidates(Request $request, $demandCode){

        $authUserId = auth('web')->user()->id;

        $demand = CompanyDemand::where('demand_code', $demandCode)
            ->where('company_id', $authUserId)
            ->first();

        $company = Company::where('user_id', $authUserId)->latest()->first();
        if (!$demand) {
            if ($request->ajax()) {
                return DataTables::of([])->make(true);
            }
        }
        $languageIds = CompanyDemand::where('demand_code', $demandCode)
            ->with('languages')
            ->get()
            ->pluck('languages.*.id')
            ->collapse() // Flatten the collection
            ->unique() // Ensure unique language IDs
            ->all();


        $authUser = auth()->user();
        if ($authUser && $authUser->companyInfo) {
            $authCompanyId = $authUser->companyInfo->id;

            $demands = User::where('user_type', UserTypes::CANDIDATE)
                ->whereHas('candidateCompany', function ($query) use($authCompanyId) {
                    $query->where('demand_status', UserDemandStatus::Interview);
                    $query->whereIn('interview_status', ['Selected', 'UnSelected', 'KIV', 'Accepted', 'Declined']);
                    $query->where('company_id', $authCompanyId);
                })
                ->whereHas('userDetail', function ($query) use ($demand) {
                    if ($demand->gender !== 'both') {
                        $query->where('gender', $demand->gender);
                    }
                    $query->where('height', '>=', $demand->height)
                        ->where('weight', '>=', $demand->weight)
                        ->where('total_work_experience', '>=', $demand->experience_year)
                        ->whereBetween('age', [$demand->age_from, $demand->age_to]);
                })
                ->whereHas('educations', function ($query) use ($demand) {
                    $query->where('edu_level', '>=', $demand->edu_level);
                })
                ->get();
        } else {
            // Handle cases where the auth user or their company info is not available
            // For example, return an empty collection or null
            $demands = collect(); // or null, based on how you want to handle this scenario
        }

        $userId = $authUserId;
        $requiredCategoryIds = DB::table('category_company')->where('user_id', $userId)->pluck('category_id')->toArray();
        $filteredUsers = $demands->filter(function ($user) use ($languageIds, $requiredCategoryIds) {
            $userLanguageIds = $user->manyLanguages->pluck('id')->all();

            $userCategoryIds = DB::table('category_details')
                ->where('user_id', $user->id) // Assuming each user has a unique 'id'
                ->pluck('category_id')
                ->toArray();

            // Ensuring the user knows all required languages
            $languageCheck = !array_diff($languageIds, $userLanguageIds);

            // Checking for at least one matching category between the user's and the demand's
            $matchingCategories = array_intersect($requiredCategoryIds, $userCategoryIds);
            $categoryCheck = !empty($matchingCategories); // True if there's at least one match

            // Include users who pass both checks
            return $languageCheck && $categoryCheck;
        });

        session(['currentDemand' => $demand]);

        if($request->ajax()){
            return DataTables::of($filteredUsers)
                ->addIndexColumn()
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })
                ->addColumn('interview_status', function($row) use($company, $demand) {
                     // Ensure the demand_status is fetched; you might need to adjust this depending on your model structure
                     return $row->candidateCompany()->where([
                        'company_id'=>$company?->id,
                        'demand_id'=>$demand->id,
                    ])->latest()->first()?->interview_status ?? 'N/A'; // Assuming candidateCompany is the relationship name
                })
                ->addColumn('action', function($row) {
                    // Assuming you have a demand ID in your session
                    $demandId = session('currentDemand')->id ?? null; // Use a null coalescing operator as a fallback

                    $infoUrl = route('user.detail', ['id' => $row->id, 'demandId' => $demandId]);
                    $printUrl = route('candidate.printCandidateApplication', ['id' => $row->id]);

                    return "<div>
                    <a href='{$printUrl}' target='_blank' title='Print'><button class='btn btn-sm btn-secondary'><i class='mdi mdi-cloud-print'></i></button></a>
                    <a href='{$infoUrl}' title='Details'><button class='btn btn-sm btn-primary'><i class='mdi mdi-information-outline'></i></button></a>
                </div>";
                })

                ->rawColumns(['DT_RowIndex', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight','demand_status'])
                ->make(true);
        }
        return view('backend.pages.all-demands.index', [
            'demands' => $demands,
            'currentDemand' => session('currentDemand')
        ]);

    }

    public function managerApprovedDemandCandidates(Request $request, $demandCode)
    {
        $companyDemand = CompanyDemand::where('demand_code', $demandCode)->firstOrFail(); // Directly abort if not found
        $companyUser = User::where('id', $companyDemand->company_id)->first();
        $company = Company::where('user_id', $companyUser->id)->first();
        $demandId = $companyDemand->id; // Use this directly
        // Set current demand in session
        // session(['currentDemand' => $filteredUsers]);
        if ($request->ajax()) {
            $data_type = $request->data_type ?? 'all';
            
            $filteredUsers = User::where('user_type', UserTypes::CANDIDATE)
            ->whereHas('candidateCompany', function ($query) {

                // this is mommented due to the filter of user interview
                // $query->where('demand_status', UserDemandStatus::Approved);

            })
            ->whereHas('candidateCompany', function ($query) use ($demandId) {
                $query->where('demand_id', $demandId);
            });

            $filteredUsers->when(($data_type && $data_type !== 'all'), function($query) use($data_type, $companyDemand) {
                $query->whereHas('interviews', function($query) use($data_type, $companyDemand) {
                    $query->where('demand_id', $companyDemand->id)
                          ->where('demand_code', $companyDemand->demand_code);
            
                    switch ($data_type) {
                        case 'all':
                            // No additional conditions
                            break;
                        case 'scheduled':
                            $query->where('is_taken', false)->where('is_selected', false);
                            break;
                        case 'selected':
                            $query->where('is_taken', true)->where('is_selected', true);
                            break;
                        case 'rejected':
                            $query->where('is_taken', true)->where('is_selected', false);
                            break;
                        default:
                            // No additional conditions
                            break;
                    }
                });
            });
            
            

            return DataTables::of($filteredUsers)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($candidate) {
                    return '<input type="checkbox" name="candidate_id[]" value="'.$candidate->id.'">';
                })
                // Add your columns as before
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })
                ->addColumn('demand_status', function($row) use($company, $companyDemand) {
                    // Ensure the demand_status is fetched; you might need to adjust this depending on your model structure
                    return $row->candidateCompany()->where([
                       'company_id'=>$company?->id,
                       'demand_id'=>$companyDemand->id,
                   ])->latest()->first()?->demand_status ?? 'N/A'; // Assuming candidateCompany is the relationship name
                })
                ->addColumn('interview_status', function($row) use($companyDemand) {
                    $interView = Interview::where('user_id', $row->id)->where('demand_id', $companyDemand->id)->where('demand_code', $companyDemand->demand_code)->latest()->first();
                    $status = "Not Scheduled";
                    if($interView){
                        if(!(bool)$interView->is_taken){
                            if($interView->reschedule_date){
                                $status = "Rescheduled At ".\Carbon\Carbon::parse($interView->reschedule_date)->format('Y-m-d').' '.\Carbon\Carbon::parse($interView->reschedule_time)->format('h:i A');
                            }else{
                                $status = "Scheduled At ".\Carbon\Carbon::parse($interView->interview_date)->format('Y-m-d').' '.\Carbon\Carbon::parse($interView->interview_time)->format('h:i A');
                            }
                        }
                        if((bool)$interView->is_taken){
                            $status = "Taken ". ((bool)$interView->is_selected ? '(Selected)' : 'Rejected');
                        }
                        

                    }
                    return $status;
                })

                ->addColumn('user_accpeptance', function($row) use($companyDemand) {
                    $interView = Interview::where('user_id', $row->id)->where('demand_id', $companyDemand->id)->where('demand_code', $companyDemand->demand_code)->latest()->first();
                    $status = "Pending";
                    if($interView){
                        $status = $interView->user_accept_status;
                    }
                    return $status;
                })
                // Add other columns...
                ->addColumn('action', function ($row) {
                    $printUrl = route('candidate.printCandidateApplication', ['id' => $row->id]);
                    return "<div>
                <a href='{$printUrl}' target='_blank' title='Print'><button class='btn btn-sm btn-secondary'><i class='mdi mdi-cloud-print'></i></button></a>
                </div>";
                })
                ->rawColumns(['DT_RowIndex','checkbox', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight','demand_status'])
                ->make(true);
        }

        // For non-AJAX request, return your view as before
        return view('backend.pages.all-demands.managerIndex', [
            'demands' => $companyDemand, // Make sure this variable is correctly set for your view
            'currentDemand' => session('currentDemand')
        ]);
    }

    public function managerInterviewDemandCandidates(Request $request, $demandCode){
        $companyDemand = CompanyDemand::where('demand_code', $demandCode)->first();
        if (!$companyDemand) {
            abort(404, 'Demand not found.');
        }
        $company = Company::where('user_id', $companyDemand->company_id)->first();
        $demandId = $companyDemand->id;

        $filteredUsers = User::where('user_type', UserTypes::CANDIDATE)
            ->whereHas('candidateCompany', function ($query) {
                $query->where('demand_status', UserDemandStatus::Interview);
            })
            ->whereHas('candidateCompany', function ($query) {
                $query->whereIn('interview_status', ['Selected', 'UnSelected', 'Accepted', 'Declined']);
            })
            ->whereHas('candidateCompany', function ($query) use ($demandId) {
                $query->where('demand_id', $demandId);
            })
            ->get();
        // Set current demand in session
        session(['currentDemand' => $filteredUsers]);

        if ($request->ajax()) {
            if ($filteredUsers->isEmpty()) {
                return DataTables::of([])->make(true);
            }

            return DataTables::of($filteredUsers)
                ->addIndexColumn()
                // Add your columns as before
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })
                ->addColumn('interview_status', function($row) use($company, $companyDemand) {
                    // Ensure the demand_status is fetched; you might need to adjust this depending on your model structure
                    return $row->candidateCompany()->where([
                       'company_id'=>$company?->id,
                       'demand_id'=>$companyDemand->id,
                   ])->latest()->first()?->interview_status ?? 'N/A'; // Assuming candidateCompany is the relationship name
               })
                // Add other columns...
                ->addColumn('action', function ($row) {
                    $printUrl = route('candidate.printCandidateApplication', ['id' => $row->id]);
                    $detailUrl = route('user.details', ['id' => $row->id]);
                    return "<div>
                <a href='{$printUrl}' target='_blank' title='Print'><button class='btn btn-sm btn-secondary'><i class='mdi mdi-cloud-print'></i></button></a>
                <a href='{$detailUrl}'  title='Detail'><button class='btn btn-sm btn-primary'><i class='mdi mdi-information'></i></button></a>
                </div>";
                })
                ->rawColumns(['DT_RowIndex', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight','interview_status'])
                ->make(true);
        }

        return view('backend.pages.all-demands.managerIndex', [
            'demands' => $companyDemand, // Make sure this variable is correctly set for your view
            'currentDemand' => session('currentDemand')
        ]);

    }



    public function receptionistSelectedCandidates(Request $request, $demandCode){
        $companyDemand = CompanyDemand::where('demand_code', $demandCode)->first();

        if (!$companyDemand) {
            abort(404, 'Demand not found.');
        }
        if ($request->ajax()) {

            $demandId = $companyDemand->id;
            $filteredUsers = User::where('user_type', UserTypes::CANDIDATE)
                ->whereHas('candidateCompany', function ($query) {
                    $query->where('demand_status', UserDemandStatus::Interview);
                })
                ->whereHas('candidateCompany', function ($query) {
                    $query->where('interview_status', [UserInterviewStatus::Selected]);
                })
                ->whereHas('candidateCompany', function ($query) use ($demandId) {
                    $query->where('demand_id', $demandId);
                })
                ->get();


            if ($filteredUsers->isEmpty()) {
                return DataTables::of([])->make(true);
            }

            
            return DataTables::of($filteredUsers)
                ->addIndexColumn()
                // Add your columns as before
                ->addColumn('full_name', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->full_name;
                })
                ->addColumn('permanent_address', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->permanent_address;
                })
                ->addColumn('gender', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->gender;
                })
                ->addColumn('age', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->age;
                })

                ->addColumn('height', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->height;
                })

                ->addColumn('weight', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->userDetail)->weight;
                })
                ->addColumn('passport_number', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->passport_number;
                })

                ->addColumn('expiry_date', function($row){
                    // Use optional to avoid trying to get property of non-object
                    return optional($row->passportDetail)->expiry_date;
                })

                ->addColumn('total_work_experience', function($row){
                    return $row->total_work_experience;
                })
                ->addColumn('interview_status', function($row) {
                    // Ensure the demand_status is fetched; you might need to adjust this depending on your model structure
                    return $row->candidateCompany->interview_status ?? 'N/A'; // Assuming candidateCompany is the relationship name
                })
                // Add other columns...
                ->addColumn('action', function ($row) {
                    $printUrl = route('candidate.printCandidateApplication', ['id' => $row->id]);
                    return "<div>
                <a href='{$printUrl}' target='_blank' title='Print'><button class='btn btn-sm btn-secondary'><i class='mdi mdi-cloud-print'></i></button></a>
                <button class='btn btn-sm btn-secondary' data-toggle='modal' data-target='#printModal' data-url='{$row->printUrl}'>
                    <i class='mdi mdi-cloud-print'></i>
                </button>
                </div>";
                })
                ->rawColumns(['DT_RowIndex', 'full_name','action','gender','passport_number','expiry_date','total_work_experience','age','height','weight','interview_status'])
                ->make(true);
        }

        return view('backend.pages.all-demands.receptionistIndex', [
            'demands' => $companyDemand, // Make sure this variable is correctly set for your view
            'currentDemand' => session('currentDemand')
        ]);

    }





    public function deleteCandidate($candidateId){
        $candidate = (new CandidateData())->findCandidate($candidateId);

        DB::beginTransaction();
        try{
            $candidate->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Candidate deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function detail($candidateId)
    {
        // Fetch the user with related details eagerly loaded to optimize queries
        $userDetails = User::with(['userDetail', 'educationalQualification', 'passportDetail', 'workExperience', 'languageDetail', 'categoryDetail'])->where('id', $candidateId)->first();

        // Check if the user was found
        if (!$userDetails) {
            return redirect()->route('all-demand.index', $candidateId)->with('error', 'Candidate record not found');
        }

        $educationTypes = EducationType::all();
        $languages = Language::all();

        return view('backend.pages.all-demands.detail', compact('userDetails', 'educationTypes', 'languages'));
    }

    public function userDetail($candidateId, $demandId)
    {
        $userDetails = User::with(['userDetail', 'educationalQualification', 'passportDetail', 'workExperience', 'languageDetail','uploadPhoto','BankDetail','resumeDetail','categoryDetail'])->where('id', $candidateId)->first();
        // Check if the user was found
        if (!$userDetails) {
            return redirect()->route('all-demand.index', $candidateId)->with('error', 'Candidate record not found');
        }

        // Find the company candidate by user ID
        $demand = CompanyDemand::where('id', $demandId)->firstOrFail();
        $company  = Company::where('user_id', $demand->company_id)->firstOrFail();
        $companyCandidate = CompanyCandidate::where([
                'user_id'=>$candidateId,
                'company_id'=>$company?->id,
                'demand_id'=>$demand?->id,
            ])->first();

        $educationTypes = EducationType::all();
        $languages = Language::all();

        $demands = CompanyDemand::get();
        $proUsers = User::role('PRO')->get();

        $company = Company::where('user_id', auth()->user()->id)->first();
        $currentDemad = CompanyDemand::where('company_id', auth()->user()->id)->first();
        $companies = Company::get();

        return view('backend.pages.all-demands.userDetail', compact('userDetails', 'educationTypes', 'languages','demands','proUsers','companies','demandId','companyCandidate', 'company', 'currentDemad'));
    }


    public function userDetails($candidateId)
    {
        $userDetails = User::with(['userDetail', 'educationalQualification', 'passportDetail', 'workExperience', 'languageDetail','uploadPhoto','BankDetail','resumeDetail','categoryDetail'])->where('id', $candidateId)->first();

        // Check if the user was found

        if (!$userDetails) {
            return redirect()->route('all-demand.index', $candidateId)->with('error', 'Candidate record not found');
        }


        // Find the company candidate by user ID
        $companyCandidate = CompanyCandidate::where('user_id', $candidateId)->first();

        $educationTypes = EducationType::all();
        $languages = Language::all();

        $demands = CompanyDemand::get();
        $proUsers = User::role('PRO')->get();

        $companies = Company::get();

        return view('backend.pages.all-demands.userDetail', compact('userDetails', 'educationTypes', 'languages','demands','proUsers','companies','companyCandidate'));
    }







    public function printCandidateApplication($id){

        $userDetails = User::with(['userDetail', 'educationalQualification', 'passportDetail', 'workExperience', 'languageDetail','uploadPhoto','BankDetail','resumeDetail','categoryDetail','comment'])->where('id', $id)->first();

        // Check if the user was found

        if (!$userDetails) {
            return redirect()->route('all-demand.index', $id)->with('error', 'Candidate record not found');
        }

        $educationTypes = EducationType::all();
        $languages = Language::all();

        return view('backend.pages.candidates.print', compact('userDetails', 'educationTypes', 'languages'));

    }

    public function listCompanyDemands($companyId){

        $company = (new CompanyData())->getCompany($companyId);

        return response()->json($company->demandDetail);
    }

    public function printNameCard($candidateRef){

        $candidate = (new CandidateData())->findCandidateViaRef($candidateRef);
        return view('backend.pages.candidates.name-ticket', compact('candidate'));
    }

    public function viewAdditionalDocuments($candidateId){
        try{
            $candidate = (new CandidateData())->findCandidate($candidateId);
            $view = view('backend.document-process.additional-documents', compact('candidate'))->render();
            return response()->json($view);
        }catch(\Exception $e){
            return response()->json($e);
        }
    }


    public function sendDemandNotifications(Request $request, $demandId)
    {
        $demand = CompanyDemand::findOrFail($demandId); // Assuming Demand model exists
        $eligibleUsers = User::where(/* your criteria here */)->get();

        foreach ($eligibleUsers as $user) {
            $user->notify(new DemandNotification($demand));
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Notifications sent successfully!']);
        }

        return back()->with('success', 'Notifications sent successfully!');
    }
}
