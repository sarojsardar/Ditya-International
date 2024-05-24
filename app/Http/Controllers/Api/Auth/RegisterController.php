<?php

namespace App\Http\Controllers\Api\Auth;
use App\Enum\UserStatus;
use App\Enum\UserTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

use App\Models\SendCode;

class RegisterController extends Controller
{
    public function createUser(Request $request){
        $validatedData = $request->validate([
            'mobile_no' => 'required|digits:10|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //   dd($validatedData);



        $user =  User::create([
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
            'user_type' => UserTypes::CANDIDATE,
            'status' => UserStatus::Inactive,
        ]);

        if ($user){
            $user->code = SendCode::sendcode($request->mobile_no);
            $user->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'User Register Successfully',
        ], 200);


    }
}
