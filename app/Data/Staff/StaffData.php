<?php
namespace App\Data\Staff;

use App\Enum\UserTypes;
use App\Helper\ImageUploadHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffData{


    protected $request;
    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function listRoleBasedSaffs($role){
        return User::role($role)->get();
    }


    public function findStaff($id){
        return User::find($id);
    }



    public function update($staff){


        $staff->update([
            'email' => $this->request->email
        ]);

        $file = $this->request->file('profile_picture');
        $filename = $staff->userInfo->profile_picture;
        if($file){
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/staff-profiles');
        }

        if($staff->user_type == UserTypes::COMPANY){

            return '';

            // $staff->companyInfo->update([

            // ]);

        }else{
            $staff->userInfo->update([
                'first_name' => $this->request->first_name,
                'middle_name' => $this->request->middle_name,
                'last_name' => $this->request->last_name,
                'full_address' => $this->request->full_address,
                'contact' => $this->request->contact,
                'profile_picture' => $filename,
            ]);

        }
    }




}


?>
