<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function loginWithMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required','regex:/^[6-9]\d{9}$/'],
            'password' => ['required','min:8','regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/']
        ], [
            'mobile.regex' => 'Mobile number must be 10 digits and start with 6, 7, 8, or 9.',
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid mobile or password'], 401);
        }

        if ($user->role_id != 2) {
            return response()->json(['status' => false, 'message' => 'Unauthorized role'], 403);
        }

        $tokenResult = $user->createToken('MobileLoginToken');
        $token = $tokenResult->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'access_token' => $token,
            'expires_in' => $tokenResult->token->expires_at->diffInSeconds(now()),
            'user_id' => $user->id,
        ]);
    }

}
