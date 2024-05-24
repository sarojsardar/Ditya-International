<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SendCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;


class AuthController extends Controller
{

    public function createPasswordResetRequest(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|numeric|exists:users,mobile_no',
        ]);

        // Generate the OTP code
        $code = mt_rand(1000, 9999);

        // Store or update the code and timestamp in the database
        DB::table('password_resets')->updateOrInsert(
            ['mobile_no' => $request->mobile_no],
            [
                'token' => $code, // Assuming you want to store the OTP as 'token'
                'created_at' => Carbon::now()
            ]
        );

        // Send the OTP via SMS
        $response = SendCode::sendPasswordResetCode($request->mobile_no, $code);

        return response()->json(['message' => 'Password reset token sent via SMS.', 'status' => true]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|numeric',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordResetEntry = DB::table('password_resets')
            ->where('mobile_no', $request->mobile_no)
            ->first();

        // Check if the token exists and is not expired
        $tokenLifetime = 60; // Token validity in minutes
        if (!$passwordResetEntry || Carbon::parse($passwordResetEntry->created_at)->addMinutes($tokenLifetime)->isPast()) {
            return response()->json(['errors' => 'Invalid or expired token.'], 401);
        }

        // Assuming the token matches since we're not hashing it in this example
        if ($request->token != $passwordResetEntry->token) {
            return response()->json(['errors' => 'Invalid token.'], 401);
        }

        // Find user and update password
        $user = User::where('mobile_no', $request->mobile_no)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token from password_resets table
        DB::table('password_resets')->where('mobile_no', $request->mobile_no)->delete();

        return response()->json(['message' => 'Password has been successfully reset.', 'status' => true]);
    }



    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => 'Current password does not match'], 401);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password successfully changed']);
    }


    //
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User successfully logged out']);
    }

}
