<?php
namespace App\Data\Candidate;

use App\Models\Candidate;
use App\Models\ProCandidate;
use Illuminate\Http\Request;
use App\Models\CompanyCandidate;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Models\CandidatePassportDetail;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class CandidateData{

    protected $request;
    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function list(){
        $userRole = auth('web')->user()->getRoleNames()->first();

        if($userRole == "CEO" || $userRole == 'Receptionist'){
            return Candidate::all();
        }else{
            return auth('web')->user()->candidates;
        }
    }

    public function findCandidate($id){
        return Candidate::find($id);
    }

    public function findCandidateViaRef($ref){
        return Candidate::where('reference_id', $ref)->first();
    }

    public function store(){

        $filename = '';
        $additionalDocuments = [];

        if($this->request->hasFile('profile_picture')){
            $file = $this->request->file('profile_picture');
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/candidate-profiles', 'candidate');
        }

        if($this->request->hasFile('additional_documents')){
            $docs = $this->request->file('additional_documents');
            foreach($docs as $key => $doc){
                $originalName = $doc->getClientOriginalName();
                $originalName = $key.'-'.pathinfo($originalName, PATHINFO_FILENAME);
                $docName = (new ImageUploadHelper())->uploadImage($doc, 'public/uploads/additional-documents', $originalName);

                array_push($additionalDocuments, $docName);
            }
        }


        $reference_id = IdGenerator::generate(['table' => 'candidates', 'field' => 'reference_id', 'length' => 8, 'prefix' =>'DIT-']);

        return Candidate::create([
            'reference_id' => $reference_id,
            'profile' => $filename,
            'demand_id' => $this->request->demand,
            'first_name' => $this->request->first_name,
            'middle_name' => $this->request->middle_name,
            'last_name' => $this->request->last_name,
            'father_name' => $this->request->father_name,
            'mother_name' => $this->request->mother_name,
            'spouse_name' => $this->request->spouse_name,
            'gender' => $this->request->gender,
            'date_of_birth_np' => $this->request->dob_np,
            'date_of_birth_en' => $this->request->dob_en,
            'contact' => $this->request->contact,
            'email' => $this->request->email,
            'nationality' => 'Nepali',
            'marital_status' => $this->request->marital_status,
            'weight' => $this->request->weight,
            'height' => $this->request->height,
            'temp_address' => $this->request->temp_address,
            'permanent_address' => $this->request->permanent_address,
            'user_id' => auth('web')->id(),
            'pro_id' => $this->request->pro_id,
            'additional_documents' => implode(',', $additionalDocuments)    
        ]);
    }


    public function update($id){

        $candidate = $this->findCandidate($id);
        $filename = $candidate->profile;
        if($this->request->hasFile('profile_picture')){
            $file = $this->request->file('profile_picture');
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/candidate-profiles', 'candidate');
        }

        $prevAdditional = $candidate->additional_documents;
        $additionalDocuments = [];
        if($this->request->hasFile('additional_documents')){
            $docs = $this->request->file('additional_documents');
            foreach($docs as $key => $doc){
                $originalName = $doc->getClientOriginalName();
                $originalName = $key.'-'.pathinfo($originalName, PATHINFO_FILENAME);
                $docName = (new ImageUploadHelper())->uploadImage($doc, 'public/uploads/additional-documents', $originalName);

                array_push($additionalDocuments, $docName);
            }

            $prevAdditional = implode(',', $additionalDocuments);
        }

        $candidate->update([
            'profile' => $filename,
            'demand_id' => $this->request->demand,
            'first_name' => $this->request->first_name,
            'middle_name' => $this->request->middle_name,
            'last_name' => $this->request->last_name,
            'father_name' => $this->request->father_name,
            'mother_name' => $this->request->mother_name,
            'spouse_name' => $this->request->spouse_name,
            'gender' => $this->request->gender,
            'date_of_birth_np' => $this->request->dob_np,
            'date_of_birth_en' => $this->request->dob_en,
            'contact' => $this->request->contact,
            'email' => $this->request->email,
            'nationality' => 'Nepali',
            'marital_status' => $this->request->marital_status,
            'weight' => $this->request->weight,
            'height' => $this->request->height,
            'temp_address' => $this->request->temp_address,
            'permanent_address' => $this->request->permanent_address,
            'pro_id' => $this->request->pro_id,
            'additional_documents' => $prevAdditional        
        ]);

        return $candidate;

    }


    public function storeOtherDetail($candidateId){

        CompanyCandidate::create([
            'company_id' => $this->request->company_id,
            'candidate_id' => $candidateId,
        ]);
    }


    function candidatePassportStore($request, $candidateId){

        $passports = [];

        if($request->hasFile('passport_images')){
            $files = $request->file('passport_images');

            foreach($files as $key => $file){
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/passport-images', $key);
                array_push($passports, $filename);
            }
    
            CandidatePassportDetail::create([
                'passport_no' => $request->passport_no,
                'passport_issue_date' => $request->date_of_issue,
                'passport_expiry_date' => $request->date_of_expiry,
                'place_of_birth' => $request->birth_place,
                'candidate_id' => $candidateId,
                'passport_images' => implode(',', $passports)
            ]);
        }
    }

    function updateCandidatePassportDetails($request, $candidate){

        $passports = [];
        $passData = $candidate->passportDetails->passport_images;
        if($request->hasFile('passport_images')){
            $files = $request->file('passport_images');

            foreach($files as $key => $file){
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/passport-images', $key);
                array_push($passports, $filename);
            }

            $passData = implode(',', $passports);
        }


        $candidate->passportDetails->update([
            'passport_no' => $request->passport_no,
            'passport_issue_date' => $request->date_of_issue,
            'passport_expiry_date' => $request->date_of_expiry,
            'place_of_birth' => $request->birth_place,
            'passport_images' => $passData
        ]);
    }

    function uniqueCandidateId(){
        do {
            $refrence_id = uniqid();
            return $refrence_id;
         } while ( DB::table( 'candidates' )->where( 'reference_id', $refrence_id )->exists() );
    }


} 