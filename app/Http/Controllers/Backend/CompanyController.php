<?php

namespace App\Http\Controllers\Backend;

use App\Data\Candidate\CompanyCandidateData;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use Yajra\DataTables\DataTables;
use App\Data\company\CompanyData;
use App\Data\Country\CountryData;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Candidat\MedicalCheckup;
use App\Models\CompanyCandidate;
use App\Models\User;

class CompanyController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $companies = (new CompanyData())->companyList();
            return DataTables::of($companies)
                ->addIndexColumn()
                ->addColumn('current_quota', function($row){
                    // this may update after the complete of all process
                    $completed = 0;
                    $companyDemand = CompanyDemand::where('company_id', $row->id)
                    ->whereIn('status', ['Open', 'Pending'])
                    ->latest()->first();
                    return $completed .'/'.$companyDemand->quota;

                })
                ->addColumn('wished_list', function($row){
                    $companyDemand = CompanyDemand::where('company_id', $row->id)
                    ->whereIn('status', ['Open', 'Pending'])
                    ->latest()->first();
                    $wishList = [];
                    if($companyDemand){
                        $wishList = (new CompanyCandidateData)->getWishListCandidate($companyDemand->demand_code);
                    }
                    $infoUrl = route('manager-demand.index', $row->id);
                    return '<a href="'.$infoUrl.'" target="_blank">'.count($wishList).'</a>';
                })
                ->addColumn('logo', function($row){
                    $url = url('/storage/uploads/company-logo/'. $row->logo);
                    return "<img src='{$url}' alt='company logo' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
                })
                ->addColumn('country', function($row){
                    return $row->originCountry->code.' | '.$row->originCountry->name;
                })
                ->addColumn('categories', function ($company) {
                    return $company->categories->pluck('name')->implode(', ');
                })
                ->addColumn('email', function($row){
                    return @$row->user->email;
                })
                ->addColumn('action', function($row){
                    $infoUrl = route('manager-demand.index', $row->id);

                    $editUrl = route('company.edit', $row->id);

                    if(auth('web')->user()->hasRole('Manager'))
                        return "<div>
                        <a href='$infoUrl' title='Info'><button class='btn btn-sm btn-secondary'>View Demand</button></a>
                        </div>";
                    else {
                        return "<div class='btn-group'>
                        <a href='{$editUrl}' class='btn btn-group' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                        </div>";
                    }
                })
                ->rawColumns(['DT_RowIndex', 'logo', 'action', 'wished_list'])
                ->make(true);
        }
        return view('backend.pages.company.index');
    }



    public function medicalProcess(Request $request){
        if($request->ajax()){
            $companies = (new CompanyData())->companyList();
            return DataTables::of($companies)
                ->addIndexColumn()
                ->addColumn('logo', function($row){
                    $url = url('/storage/uploads/company-logo/'. $row->logo);
                    return "<img src='{$url}' alt='company logo' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
                })
                ->addColumn('medical_status', function($row){
                    $infoUrl = route('receptionist-demand.index', $row->user_id);
                    $companyCandidate = CompanyCandidate::where('company_id', $row->id)
                                        ->where('interview_status', 'Selected')
                                        ->where('medical_status', '!=', null)
                                        // This may be changed according to the status if required
                                        // ->where('demand_status', 'Interview')
                                        ->get();
                    
                    // this is developed according to old database design
                    $companyUser = User::where('id', $row->user_id)->first();
                    $currentDemand = CompanyDemand::where('company_id', $companyUser->id)->whereIn('status', ['Open', 'Pending'])->latest()->first();
                    $tested = 0;
                    $fit = 0;
                    $unfit = 0;
                    if($currentDemand){
                        $medicalChecklups = MedicalCheckup::where([
                            'demand_id'=>$currentDemand->id,
                            'demand_code'=>$currentDemand->demand_code,
                            'is_tested'=>true,
                        ])->get();

                        $tested = collect($medicalChecklups)->filter(function($row){
                            return (bool)$row->is_tested == true;
                        })->count();
    
    
                        $fit = collect($medicalChecklups)->filter(function($row){
                            return (bool)$row->status == 'Fit';
                        })->count();

                        $unfit = collect($medicalChecklups)->filter(function($row){
                            return (bool)$row->status == 'Unfit';
                        })->count();
                    }

                    $infoUrl = route('receptionist-demand.index', $row->user_id);
                    $return_string = '
                        <div>
                            <p class="m-0 p-0">Total:'.count($companyCandidate).'</p>
                            <p class="m-0 p-0">Tested:'.$tested.'</p>
                            <p class="m-0 p-0">Fit:'.$fit.'</p>
                            <p class="m-0 p-0">Unfit:'.$unfit.'</p>';
                            // this may be enable if required on the receptionist
                            // $return_string .='<p class="m-0 p-0"><a class="btn btn-primary" href="'.$infoUrl.'" title="Info">View</a></p>';

                        $return_string .= '</div>';
                    return $return_string;
                })
                ->addColumn('country', function($row){
                    return $row->originCountry->code.' | '.$row->originCountry->name;
                })
                ->addColumn('categories', function ($company) {
                    return $company->categories->pluck('name')->implode(', ');
                })
                ->addColumn('email', function($row){
                    return @$row->user->email;
                })
                ->addColumn('action', function($row){
                    $infoUrl = route('receptionist-demand.index', $row->user_id);

                    $editUrl = route('company.edit', $row->id);

                    if(auth('web')->user()->hasRole('Receptionist'))
                        return "<div>
                        <a href='$infoUrl' title='Info'><button class='btn btn-sm btn-secondary'>View Demand</button></a>
                        </div>";
                    else {
                        return "<div class='btn-group'>
                        <a href='{$editUrl}' class='btn btn-group' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                        </div>";
                    }
                })
                ->rawColumns(['medical_status', 'DT_RowIndex', 'logo', 'action', 'selected'])
                ->make(true);
        }
        return view('backend.pages.company.medical_process');
    }



    public function receptionist(Request $request){

        $companies = (new CompanyData())->companyList();
        if($request->ajax()){
            return DataTables::of($companies)
                ->addIndexColumn()
                ->addColumn('logo', function($row){
                    $url = url('/storage/uploads/company-logo/'. $row->logo);
                    return "<img src='{$url}' alt='company logo' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
                })
                ->addColumn('selected', function($row){
                    $infoUrl = route('receptionist-demand.index', $row->user_id);
                    $companyCandidate = CompanyCandidate::where('company_id', $row->id)
                                        ->where('interview_status', 'Selected')
                                        ->where('medical_status', null)
                                        // This may be changed according to the status if required
                                        // ->where('demand_status', 'Interview')
                                        ->get();
                    return "<a href='".$infoUrl."'>". count($companyCandidate)."</a>";
                })
                ->addColumn('country', function($row){
                    return $row->originCountry->code.' | '.$row->originCountry->name;
                })
                ->addColumn('categories', function ($company) {
                    return $company->categories->pluck('name')->implode(', ');
                })
                ->addColumn('email', function($row){
                    return @$row->user->email;
                })
                ->addColumn('action', function($row){
                    $infoUrl = route('receptionist-demand.index', $row->user_id);

                    $editUrl = route('company.edit', $row->id);

                    if(auth('web')->user()->hasRole('Receptionist'))
                        return "<div>
                        <a href='$infoUrl' title='Info'><button class='btn btn-sm btn-secondary'>View Demand</button></a>
                        </div>";
                    else {
                        return "<div class='btn-group'>
                        <a href='{$editUrl}' class='btn btn-group' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                        </div>";
                    }
                })
                ->rawColumns(['DT_RowIndex', 'logo', 'action', 'selected'])
                ->make(true);
        }
        return view('backend.pages.company.receptionist');
    }



    public function create(){
        $company = new Company();
        $countries = (new CountryData())->countryList();
        $categories = Category::all();
        return view('backend.pages.company.form', compact('company', 'countries','categories'));
    }
    public function edit($id){
        $company = (new CompanyData())->getCompany($id);
        $countries = (new CountryData())->countryList();
        $categories = Category::all();
        return view('backend.pages.company.form', compact('company', 'countries','categories'));
    }

    public function store(Request $request){

        $request->validate([
            'company_name' => 'required|unique:companies,name',
            'company_email' => 'required|unique:users,email'
        ]);

        try{

            DB::beginTransaction();
            (new CompanyData($request))->store();
            DB::commit();

            return redirect()->route('company.index')->with('success', 'Company added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);
        }
    }


    public function update(Request $request, $id) {

        $company = Company::find($id);

        $validated = $request->validate([
            'company_name' => 'required|unique:companies,name,' . $company->id,
            'company_email' => 'required|unique:users,email,' . $company->user->id ?? '',
            'company_logo' => 'sometimes|file|image|max:2048',
            'country' => 'required',
            'categories' => 'sometimes|array|exists:categories,id'
        ]);

        try {
            DB::beginTransaction();
            $filename = $company->logo;
            if ($request->hasFile('company_logo')) {
                $file = $request->file('company_logo');
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/company-logo', 'logo');
            }

            $company->update([
                'name' => $validated['company_name'],
                'email' => $validated['company_email'],
                'logo' => $filename,
                'country' => $validated['country'],
            ]);

            if (isset($validated['categories'])) {
                $company->categories()->sync($validated['categories']);
            }

            DB::commit();

            return redirect()->route('company.index')->with('success', 'Company details updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update company: ' . $e->getMessage());
            return back()->with('error', 'Failed to update company details.');
        }
    }


}
