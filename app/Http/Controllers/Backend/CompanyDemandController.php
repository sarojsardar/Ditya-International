<?php

namespace App\Http\Controllers\Backend;

use App\Action\NotificationAction;
use App\Models\User;
use App\Models\Year;
use App\Models\Gender;
use App\Enum\UserTypes;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Language;
use App\Models\SendCode;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Models\EducationType;
use App\Jobs\SendInterviewSms;
use App\Jobs\SendReinterviewSms;
use App\Models\CompanyCandidate;
use Yajra\DataTables\DataTables;
use App\Data\company\CompanyData;
use App\Data\Country\CountryData;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Data\CompanyDemand\CompanyDemandData;

class CompanyDemandController extends Controller
{

    public function index(Request $request){
        
        $user = Auth::user();
        $userId = $user->id;
        $companyDemand =  CompanyDemand::where('company_id', $userId)->orderBy('created_at', 'desc');
        
        if($request->ajax()){
            return DataTables::of($companyDemand)
            ->addIndexColumn()

            ->addColumn('age_from', function($row){
                return $row->age_from.' '.'Years';
            })

            ->addColumn('age_to', function($row){
                return $row->age_to.' '.'Years';
            })

            ->addColumn('height', function($row){
                return $row->height.' '.'Feet';
            })

            ->addColumn('weight', function($row){
                return $row->weight.' '.'Kg';
            })
            ->addColumn('experience_year', function($row){
                return $row->experience_year.' '.'Years';
            })
            ->addColumn('action', function($row){
                $editUrl = route('company-demand.edit', $row->id);
                return "<div>
                <a href='$editUrl' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                </div>";
            })
            ->rawColumns(['company', 'country', 'action', 'DT_RowIndex', 'color', 'cancelled'])
            ->make(true);
        }

        return view('backend.pages.company-demand.index');
    }


    public function allIndex(Request $request){

        $demands = (new CompanyDemandData())->demandList();

        return view('backend.pages.all-demands.index', compact('demands'));
    }

    public function approvedIndex(Request $request){

        $demands = (new CompanyDemandData())->demandList();

        return view('backend.pages.all-demands.approved', compact('demands'));
    }


    public function interviewIndex(Request $request){

        $demands = (new CompanyDemandData())->demandList();

        return view('backend.pages.all-demands.interview', compact('demands'));
    }

    public function managerIndex($companyId){


        $demands =  CompanyDemand::where('company_id', $companyId)->orderBy('created_at', 'desc')->get();

        return view('backend.pages.all-demands.managerIndex', compact('demands'));
    }


    public function managerInterviewIndex($companyId){


        $demands =  CompanyDemand::where('company_id', $companyId)->orderBy('created_at', 'desc')->get();

        return view('backend.pages.all-demands.manager.interview', compact('demands'));
    }


    public function receptionistIndex($companyId){

        $demands =  CompanyDemand::where('company_id', $companyId)->orderBy('created_at', 'desc')->get();

        return view('backend.pages.all-demands.receptionistIndex', compact('demands'));
    }


    public function create(){
       //   dd($request->all());


        // $demand = CompanyDemand::whereNotIn('status', ['close', 'completed'])->latest()->first();
        // if($demand){
        //     session()->flash('error', 'Sorry You have already opened a demand, please close or complete your demand first');
        //     return redirect()->route('company-demand.index');
        // }


        $genders = Gender::all();
        $languages = Language::all();
        $educations = EducationType::all();
        $years = Year::all();
        $demand = new CompanyDemand();
        return view('backend.pages.company-demand.form', compact( 'demand','genders','educations','languages','years'));
    }


    public function edit($id){;
        $countries = (new CountryData())->countryList();
        $genders = Gender::all();
        $languages = Language::all();
        $educations = EducationType::all();
        $years = Year::all();
        $demand = (new CompanyDemandData())->getDemand($id);
        return view('backend.pages.company-demand.form', compact('genders', 'languages', 'educations', 'demand','countries','years'));
    }


    public function getCompanyDetail($id){
        $company = (new CompanyData())->getCompany($id);
        $countries = (new CountryData())->countryList();
        $view = view('backend.pages.company-demand.company-info', compact('company', 'countries'))->render();
        return response()->json($view);
    }

    public function store(Request $request){

        $demand = CompanyDemand::whereNotIn('status', ['close', 'completed'])->latest()->first();
        if($demand){
            session()->flash('error', 'Sorry You have already opened a demand, please close or complete your demand first');
            return redirect()->route('company-demand.index');
        }
        DB::beginTransaction();
        try{

            (new CompanyDemandData($request))->store();

            DB::commit();
            return redirect()->route('company-demand.index')->with('success', 'Demand generated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);
        }

    }

    public function update(Request $request, $id){
        // Validate the company ID first
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        // Use findOrFail to automatically throw a ModelNotFoundException if no company is found
        $company = Company::findOrFail($request->company_id);

        // Validate the rest of the request data
        $request->validate([
            // 'company_name' => 'required|unique:companies,name,'.$company->id,
            // 'company_email' => 'required|email|unique:users,email,'.$company->user_id,
            // 'company_address' => 'required',
            // 'country' => 'required',
            // 'office_rate' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'quota' => 'required',
            // 'quota_value' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            // 'company_logo' => 'sometimes|required|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            // 'demand_letter.*' => 'sometimes|required|image|mimes:jpg,jpeg,png,gif|max:4048',
        ]);

        DB::beginTransaction();
        // try {
            // It's safer to use the validated company rather than fetching again
            // $company = (new CompanyData())->getCompany($request->company_id);

            $demand = (new CompanyDemandData())->getDemand($id);
            $usedQuota = $demand->quota_value - $demand->remaining_quota;

            if($usedQuota > $request->quota_value){
                return back()->with('error', 'Cannot decrease quota. Previous quotas are all used. Please proceed to quota management before any changes!');
            }

            // Update company and demand data
            // (new CompanyData($request))->update($company->id);
            (new CompanyDemandData($request))->update($id);

            // Assuming you might want to refresh the $demand after updates
            $demand->refresh();

            // foreach($demand->candidates as $candidate){
            //     if($candidate->invoice){
            //         $candidate->invoice->update([
            //             'total_payment' => $request->office_rate
            //         ]);
            //     }
            // }

            DB::commit();
            return redirect()->route('company-demand.index')->with('success', 'Demand updated successfully');

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     // Consider logging the exception if you aren't already
        //     \Log::error($e->getMessage());
        //     return back()->with('error', 'An error occurred while updating the demand.');
        // }
    }


    public function detail($id){

        $demand = (new CompanyDemandData())->getDemand($id);
        return view('backend.pages.company-demand.detail', compact('demand'));
    }

    public function updateStatus(Request $request, $id)
    {
        $demand = User::findOrFail($id);

        if ($request->input('demand_status') === 'Approved' || 'Pending' || 'Rejected' && is_null($demand->reference_id)) {
            $reference_id = IdGenerator::generate([
                'table' => 'users',
                'field' => 'reference_id',
                'length' => 8,
                'prefix' => 'DIT-'
            ]);

            $demand->reference_id = $reference_id;
            $demand->demand_status = 'New';
            $demand->save();

            
            CompanyCandidate::create([
                'user_id' => $id,
                'company_id' => $request->company_id,
                'demand_id' => $request->demand_id,
                'demand_status' => $request->demand_status
            ]);


            // new code added for the notification
            try {
                $generated_by = get_class(auth()->user());
                $generated_id = auth()->user()->id;
                // This may be change according to the candidate model 
                $generated_to = get_class($demand);
                $generated_to_id = $demand->id;
                $company = Company::where('user_id', auth()->user()->id)->latest()->first();
                $title = "You Have Wishlisted By the ".$company->name;
                $go_to_url = "#";
                // in the below the href must be changed;
                $web_content = 'Congratulation You have selected by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$go_to_url.'">View More</a>';
                $mobile_content = 'Congratulation You have selected by the company  '.$company->name. ' For the further process, you may notify by our system if the interview date is declared you can view by clicking the below linnk <br> <a href="'.$go_to_url.'">View More</a>';
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
            } catch (\Throwable $th) {
                info("Error While Pushing Notification: ".$th->getMessage());
            }

            return redirect()->route('approved-demand.index')->with('success', 'Status updated successfully.');
        } else if (in_array($request->input('demand_status'), ['Pending', 'Rejected'])) {

            $demand->demand_status = $request->input('demand_status');
            $demand->save();

            return redirect()->route('all-demand.index')->with('success', 'Status updated successfully.');
        } else {

            $request->validate(['demand_status' => 'required']);

            $demand->save();

            return redirect()->route('all-demand.index')->with('success', 'Status updated successfully.');
        }

    }


    public function statusUpdate(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'interview_status' => 'required', // Add more rules as necessary
        ]);

        $companyCandidate = CompanyCandidate::where('user_id', $id)->first();

        if ($companyCandidate) {
            // If found, update the interview_status
            $companyCandidate->update([
                'interview_status' => $request->interview_status
            ]);

            // Redirect with a success message
            return redirect()->route('interview-demand.index')->with('success', 'Status updated successfully.');

        } else {
            // Handle the case where no CompanyCandidate is found
            return redirect()->back()->with('error', 'No matching record found.');

        }
    }




    public function postComment(Request $request, $userId)
    {
        $request->validate([
            'comment' => 'required',
        ]);

         Comment::updateOrCreate(
            [
                'user_id' => $userId,
            ],
            [
                'comment' => $request->comment,
            ]
        );

        return redirect()->back()->with('success', 'Comment added successfully!');
    }


    public function postInterview(Request $request, $userId)
    {
        $request->validate([
            'interview_date' => 'required',
        ]);

        Interview::updateOrCreate(
            [
                'user_id' => $userId,
            ],
            [
                'interview_date' => $request->interview_date,
            ]
        );

        return redirect()->back()->with('success', 'Interview Date added successfully!');
    }


    public function updateStatusAndNotify(Request $request)
    {
        // Extract user IDs where user type is CANDIDATE
        $userIds = User::where('user_type', UserTypes::CANDIDATE)->pluck('id')->toArray();

        // Formatting the interview time
        $interviewTime = $request->input('interview_time');
        $readableTime = date('h:i A', strtotime($interviewTime));

        // Gather other details from the request
        $newInterviewDate = $request->input('interview_date');
        $newInterviewVenue = $request->input('interview_venue');
        $newInterviewTime = $readableTime;

        // Retrieve a single company candidate for company details
        $companyCandidate = CompanyCandidate::whereIn('user_id', $userIds)
            ->with('company')
            ->first();

        $companyName = optional($companyCandidate->company)->name ?? '';

        foreach ($userIds as $userId) {
            $interview = Interview::updateOrCreate(
                ['user_id' => $userId],
                ['interview_date' => $newInterviewDate, 'interview_time' => $newInterviewTime, 'interview_venue' => $newInterviewVenue]
            );

            $user = User::find($userId);
            if ($user) {
                if ($interview->wasRecentlyCreated) {
                    SendInterviewSms::dispatch($user->mobile_no, $interview->interview_date, $interview->interview_time, $interview->interview_venue, $companyName);
                } else {
                    SendReinterviewSms::dispatch($user->mobile_no, $interview->interview_date, $interview->interview_time, $interview->interview_venue, $companyName);
                }
            }
        }

        return back()->with('success', 'Selected users updated and notified successfully.');
    }



    public function updateCandidateStatus(Request $request)
    {
        $candidate = CompanyCandidate::where('user_id', $request->id)->first();


        if ($candidate) {
            $candidate->medical_status = $request->medical_status; // 'approve' or 'reject'
            $candidate->save();
            return response()->json(['success' => 'Status updated successfully']);
        }

        return response()->json(['error' => 'Candidate not found'], 404);
    }


    public function updateCandidateInterviewStatus(Request $request)
    {

     //   dd($request->all());
        $candidate = CompanyCandidate::where('user_id', $request->id)->first();


        if ($candidate) {
            $candidate->interview_status = $request->interview_status; // 'approve' or 'reject'
            $candidate->save();
            return response()->json(['success' => 'Status updated successfully']);
        }

        return response()->json(['error' => 'Candidate not found'], 404);
    }






}
