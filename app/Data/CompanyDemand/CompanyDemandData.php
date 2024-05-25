<?php
namespace App\Data\CompanyDemand;

use App\Models\EducationType;
use Illuminate\Http\Request;
use App\Models\CompanyDemand;
use App\Helper\ImageUploadHelper;
use App\Enum\DocumentProcessStatus;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class CompanyDemandData{

    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function demandList(){
        $user = Auth::user();
        $userId = $user->id;
        return CompanyDemand::where('company_id', $userId)->orderBy('created_at', 'desc')->get();
    }







    public function getDemand($id){
        return CompanyDemand::find($id);
    }
    public function getDemandViaCode($code){
        return CompanyDemand::where('demand_code', $code)->first();
    }

    public function availableQuotaList(){
        return CompanyDemand::where('remaining_quota', '>', '0')->orderBy('demand_code', 'desc')->get();
    }
    public function completedQuotaList(){
        return CompanyDemand::where('remaining_quota', '=', '0')->orderBy('demand_code', 'desc')->get();
    }

    public function store(){

     // dd($this->request->all());
        $demandLetters = [];
        $files = $this->request->file('demand_letter');

        foreach($files as $key => $file){
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/company-demand-letters', $key);
            array_push($demandLetters, $filename);
        }


        try{


            $demandCode = IdGenerator::generate(['table' => 'company_demands', 'field' => 'demand_code', 'length' => 10, 'prefix' =>'DMD-']);
            $user = Auth::user();
            $userId = $user->id;

            $educationType = EducationType::where('name', $this->request->education)->first();

            $companydemand =  CompanyDemand::create([
                'company_id' => $userId,
                'demand_code' => $demandCode,
                'demand_letter' => (implode(',', $demandLetters)),
                'quota' => $this->request->quota,
                'gender' => $this->request->gender,
                'age_from' => $this->request->age_from,
                'age_to' => $this->request->age_to,
                'height' => $this->request->height,
                'weight' => $this->request->weight,
                'experience_year' => $this->request->experience_year,
                'education' => $this->request->education,
                'edu_level' => $educationType->edu_level,

            ]);

            $languageIds = $this->request->input('languages', []);

           // dd($languageIds);
          //  $languageIds =  [1, 2, 3];
            $companydemand->languages()->sync($languageIds);

        }catch(\Exception $e){
           info("Error While Creating Company Demand ".$e->getMessage());
        }

    }

    public function update($id){

        $demand = $this->getDemand($id);
        $demandLetters = $demand->demand_letter;
        $letters = [];
        if($this->request->hasFile('demand_letter')){
            $files = $this->request->file('demand_letter');

            foreach($files as $key => $file){
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/company-demand-letters', $key);
                array_push($letters, $filename);
            }

            $demandLetters = implode(',', $letters);

        }

        $usedQuota = $demand->quota_value - $demand->remaining_quota;

        $demand->update([
            'demand_letter' => $demandLetters,
            'office_rate' => $this->request->office_rate,
            'quota' => $this->request->quota,
            'quota_value' => $this->request->quota_value,
            'remaining_quota' => $this->request->quota_value - $usedQuota,
        ]);


        // if($demand->quota_value == $demand->remaining_quota){
        //     $demand->update([
        //         'demand_letter' => $demandLetters,
        //         'office_rate' => $this->request->office_rate,
        //         'quota' => $this->request->quota,
        //         'quota_value' => $this->request->quota_value,
        //         'remaining_quota' => $this->request->quota_value,
        //     ]);
        // }

    }
}
