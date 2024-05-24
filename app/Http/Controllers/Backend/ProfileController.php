<?php

namespace App\Http\Controllers\Backend;

use App\Enum\UserTypes;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index(){

        return view('backend.pages.profile.index');
    }

    public function updateProfile(Request $request){

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);

        $newPass = $request->new_password;
        $oldPass = $request->current_password;

        $hashedPassword = auth('web')->user()->getAuthPassword();
        if (Hash::check($oldPass, $hashedPassword)) {
            //Change the password
            auth('web')->user()->fill([
                'password' => Hash::make($newPass)
            ])->save();
            return back()->with('success', 'Profile updated successfully');
        }else{
            return back()->with('error', 'Password did not match');
        }
    }

    public function uploadProfile(Request $request){

        $user = auth('web')->user();
        if($user->user_type == UserTypes::NORMAL){
            $file = $request->file('profile_picture');
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/staff-profiles', '');

            if(@$user->userInfo){
                $user->userInfo->update([
                    'profile_picture' => $filename
                ]);
            }else{
                UserInformation::create([
                    'user_id' => auth('web')->id(),
                    'profile_picture' => $filename,
                ]);
            }
            return response()->json(['status' => 'success', 'message' => 'Profile updated successfully']);
        }else{
            $file = $request->file('profile_picture');
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/company-logo', 'logo');

            $user->companyInfo->update([
                'logo' => $filename
            ]);

            return response()->json(['status' => 'success', 'message' => 'Logo updated successfully']);

        }

    }
}
