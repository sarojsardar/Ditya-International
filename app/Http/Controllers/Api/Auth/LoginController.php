<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validation;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function loginUser(Request $request)
    {
        // Validate the request data, ensuring 'mobile_no' is unique
        $request->validate([
            'mobile_no' => 'required|numeric', // Assuming mobile_no is numeric
            'password' => 'required',
        ]);

        $credentials = $request->only('mobile_no', 'password');

        try {
            // Attempt to find the user by mobile number and retrieve specific columns
            $user = User::where('mobile_no', $request->mobile_no)
                ->select('id', 'mobile_no', 'user_type','status')
                ->firstOrFail();
        } catch (\Exception $e) {
            // User not found, return error response
            return response()->json(['errors' => 'User not found'], 404);
        }

        // Check if the user account is active
        if ($user->status == 0) {
            return response()->json(['errors' => 'Your account is not active.'], 403); // 403 Forbidden status code
        }

        // Attempt authentication with provided credentials
        if ($user->status == 1 && Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('mobile-app-token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user_details' => $user,
            ]);
        }

        // Invalid credentials, return error response
        return response()->json(['errors' => 'Invalid credentials'], 401);
    }
}
