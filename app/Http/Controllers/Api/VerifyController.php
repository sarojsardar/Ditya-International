<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verifyUser(Request $request){
        $user = User::where('code', $request->code)->first();

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
