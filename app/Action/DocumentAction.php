<?php
namespace App\Action;

use App\Models\User;
use App\Models\UploadPhoto;
use App\Models\ResumeDetail;
use Illuminate\Http\Request;
use App\Models\PassportDetail;
use App\Models\CompanyCandidate;
use App\Helper\ImageUploadHelper;
use App\Models\EducationalDocument;

class DocumentAction
{
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uplodaAllDocument(CompanyCandidate $companyCandidate)
    {
        $user = User::where('id', $companyCandidate->user_id)->firstOrFail();
        $userId = $user->id;

        
        if($this->request->hasFile('passport_photo')){
            $userDetail = PassportDetail::where('user_id', $userId)->latest()->first();
            $passportImageFile = $this->request->file('passport_photo'); // Corrected variable name
            $passportImageName = pathinfo($passportImageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $passportImagePath = (new ImageUploadHelper())->uploadImage($passportImageFile, 'public/uploads/passport-images', $passportImageName);
            if($userDetail){
                $userDetail->passport_image = $passportImagePath; // Corrected field name
                $userDetail->save();
            }
        }


        if($this->request->hasFile('passport_size')){
            $userDetail = UploadPhoto::where('user_id', $userId)->latest()->first();
            $passportPhotoFile = $this->request->file('passport_size');
            $passportPhotoName = pathinfo($passportPhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $passportPhotoPath = (new ImageUploadHelper())->uploadImage($passportPhotoFile, 'public/uploads/passport-photos', $passportPhotoName);

            if($userDetail){
                $userDetail->passport_photo = $passportPhotoPath;
                $userDetail->save();
            }
        }

        if($this->request->hasFile('full_size')){
            $userDetail = UploadPhoto::where('user_id', $userId)->latest()->first();
            $fullPhotoFile = $this->request->file('full_size');
            $fullPhotoName = pathinfo($fullPhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $fullPhotoPath = (new ImageUploadHelper())->uploadImage($fullPhotoFile, 'public/uploads/full-photos', $fullPhotoName);
            if($userDetail){
                $userDetail->full_photo = $fullPhotoPath;
                $userDetail->save();
            }
        }

        if($this->request->hasFile('resume')){
            $userDetail = ResumeDetail::where('user_id', $userId)->latest()->first();
            $resumeFile = $this->request->file('resume');
            $resumeName = pathinfo($resumeFile->getClientOriginalName(), PATHINFO_FILENAME);
            $resumeFilePath = (new ImageUploadHelper())->uploadImage($resumeFile, 'public/uploads/resume-files', $resumeName);
            if($userDetail){
                $userDetail->resume_file = $resumeFilePath; // Corrected field name
            }
        }

        if($this->request->hasFile('educational_doc')){
            $eduDocFile = $this->request->file('educational_doc');
            if ($eduDocFile && $eduDocFile->isValid()) {
                $eduDocName = pathinfo($eduDocFile->getClientOriginalName(), PATHINFO_FILENAME);
                $eduDocPath = (new ImageUploadHelper())->uploadImage($eduDocFile, 'public/uploads/edu-doc', $eduDocName);
                // Update or create user educational detail
                $eduDoc = EducationalDocument::where('user_id', $userId)->latest()->first();

                if($eduDoc){
                    $eduDoc->edu_doc = $eduDocPath;
                    $eduDoc->save();
                }
            }
        }
    }
}