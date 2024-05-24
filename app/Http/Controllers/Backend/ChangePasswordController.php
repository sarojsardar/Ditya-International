<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;

class ChangePasswordController extends Controller
{


    // Change Password
    public function changePassword(){
        $admin = User::where('email', Auth::guard('web')->user()->email)->first();
        return view ('backend.changePassword', compact('admin'));
    }

    // Check User Password
    public function checkUserPassword(Request  $request){
        $data = $request->all();
        $current_password = $data['current_password'];
        $user_id = Auth::guard('web')->user()->id;
        $check_password = User::where('id', $user_id)->first();
        if(Hash::check($current_password, $check_password->password)){
            return "true"; die;
        } else {
            return "false"; die;
        }
    }

    // Update Password
    public function upatePassword(Request $request, $id){
        $validateData = $request->validate([
            'current_password' => 'required|max:255',
            'password' => 'min:6',
            'pass_confirmation' => 'required_with:password|same:password|min:6'
        ]);
        $admin = User::where('email', Auth::guard('web')->user()->email)->first();
        $current_admin_password = $admin->password;
        $data = $request->all();
        if(Hash::check($data['current_password'], $current_admin_password)){
            $admin->password = bcrypt($data['password']);
            $admin->save();
            Session::flash('message', 'Admin Password Has Been Updated Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Your Password does not match with our database');
            return redirect()->back();
        }
    }
}
