<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{
    public function verifyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'code'=>'required',
            'mobile_no'=>'required',
        ]);

        if($validator->fails()){
            return response([
                'message'=>'Unprocessable Content',
                'data'=>$validator->errors(),
                'status'=>422,
            ], 422);
        }
        $user = User::where('code', $request->code)->where('mobile_no', $request->mobile_no)->first();
        if($user){
            // Check if the user is already verified
            if ($user->status == 1) {
                return response()->json(['success' => 'Your account is already active.'], 200);
            }
            // Update user status and code
            $user->update([
                'status' => 1,
                'code' => null,
            ]);
            return response()->json(['success' => 'Your account is active now. Login to continue.'], 200);
        } else {
            return response()->json(['error' => 'Verification code is not valid.'], 401);
        }
    }
}
