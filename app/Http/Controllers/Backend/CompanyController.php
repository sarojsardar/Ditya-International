<?php

namespace App\Http\Controllers\Backend;

use App\Helper\ImageUploadHelper;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Data\company\CompanyData;
use App\Data\Country\CountryData;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index(Request $request){

        $companies = (new CompanyData())->companyList();

        if($request->ajax()){
            return DataTables::of($companies)
                ->addIndexColumn()
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
                    $infoUrl = route('manager-demand.index', $row->user_id);

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
                ->rawColumns(['DT_RowIndex', 'logo', 'action'])
                ->make(true);
        }


        return view('backend.pages.company.index');
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
                ->rawColumns(['DT_RowIndex', 'logo', 'action'])
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
