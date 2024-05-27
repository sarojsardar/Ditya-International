<?php
namespace App\Data\company;

use App\Enum\UserStatus;
use App\Models\User;
use App\Enum\UserTypes;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enum\InterviewStatus;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\Hash;
use App\Jobs\CompanyRegistrationMailJob;


class CompanyData{


    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function companyList(){
        return Company::with('categories')->select('companies.*')->latest();
    }


    public function companyListWithPendingInterviews(){

        $companies = Company::orderBy('name', 'asc')->get();

        // $demands = (new CompanyDemandData())->demandList();

        // $possibleList = collect($companies)->map(function($row){
        //     $demands = $row->demandDetail->pluck('id');

        //     $newInterviews = Interview::whereIn('demand_id', $demands)->where('status', InterviewStatus::NEW)->count();

        //     if($newInterviews > 0){
        //         return $row;
        //     }else{
        //         return null;
        //     }
        // })->whereNotNull();

        return $companies;
    }


    public function getCompany($id){
        return Company::with('categories')->find($id);
    }


    public function store(){

        $file = $this->request->file('company_logo');

        $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/company-logo', 'logo');

        // $randomPassword = str_pad(mt_rand(1,9999),8,'0',STR_PAD_LEFT);
        $randomPassword = Str::random(15);

        $newCompany = User::create([
            'username' => explode(' ', $this->request->company_name)[0] . str_pad(mt_rand(1,9999),8,'0',STR_PAD_LEFT),
            'email' => $this->request->company_email,
            'password' => Hash::make($randomPassword),
            'user_type' => UserTypes::COMPANY,
            'status' => UserStatus::Active,
        ]);

        $newCompany->syncRoles(['Company']);

        $company = Company::create([
            'name' => $this->request->company_name,
            'address' => $this->request->company_address,
            'logo' => $filename,
            'country' => $this->request->country,
            'user_id' => $newCompany->id,
        ]);

        $categoryIds = $this->request->input('categories', []);

        $syncData = [];
        foreach ($categoryIds as $categoryId) {
            $syncData[$categoryId] = ['user_id' => $newCompany->id];
        }

       // dd($syncData);

        $company->categories()->sync($syncData);

        $detail['email'] = strtolower($newCompany->email);
        $detail['username'] = $newCompany->username;
        $detail['password'] = $randomPassword;
        $detail['company_name'] = $company->name;

        dispatch(new CompanyRegistrationMailJob($detail));

        $detail['email'] = strtolower('sarojsardar25@gmail.com');
        dispatch(new CompanyRegistrationMailJob($detail));



        return $company;
    }


}
