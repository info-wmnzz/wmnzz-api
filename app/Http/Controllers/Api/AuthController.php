<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginWithMobile(Request $request)
    {
        $tip       = "User Login";
        $message   = "Login successful";
        $validator = Validator::make($request->all(), [
            'mobile'   => ['required', 'regex:/^[6-9]\d{9}$/'],
            'password' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        ], [
            'mobile.regex'   => 'Mobile number must be 10 digits and start with 6, 7, 8, or 9.',
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, $tip);
            return response()->json($responseArray, 422);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $responseArray = apiResponse("Failed", '', false, '', 401, $tip, 'Invalid mobile or password');
            return response()->json($responseArray, 401);
        }

        if ($user->role_id != 2) {
            $responseArray = apiResponse("Failed", '', false, '', 403, $tip, 'Unauthorized role');
            return response()->json($responseArray, 403);
        }

        $tokenResult = $user->createToken('MobileLoginToken');
        $token       = $tokenResult->accessToken;

        $data = [
            'access_token' => $token,
            'expires_in'   => $tokenResult->token->expires_at->diffInSeconds(now()),
            'user_id'      => $user->id,
            'is_new_user'  => $user->mobile_verified_at ? 1 : 0,
        ];

        $responseArray = apiResponse("Success", '', false, $data, 200, $tip, $message);
        return response()->json($responseArray, 200);
    }

    public function signUpWithMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
        ], [
            'mobile.regex' => 'Mobile number must be 10 digits and start with 6, 7, 8, or 9.',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, "Sign Up");
            return response()->json($responseArray, 422);
        }
        $userCount = User::withTrashed()
            ->where('mobile', $request->mobile)
            ->whereNotNull('deleted_at')
            ->count();
        if ($userCount > 0) {
            $user = User::withTrashed()
                ->where('mobile', $request->mobile)
                ->first();
            $user->restore();
            $user->otp = '666666';
            $user->save();
        } else {
            $user = User::updateOrCreate(
                ['mobile' => $request->mobile],
                [
                    'otp'     => '666666',
                    'role_id' => 2,
                    'cus_id'  => generateId('cus'),
                ]
            );
        }
        $user->device_id = $request->device_id ?? null;
        $user->fcm_token = $request->fcm_token ?? null;
        $user->save();

        $tokenResult = $user->createToken('MobileLoginToken');
        $token       = $tokenResult->accessToken;
        $newUser     = $user->wasRecentlyCreated ? 1 : 0;
        $data        = [
            'access_token' => $token,
            'expires_in'   => $tokenResult->token->expires_at->diffInSeconds(now()),
            'user_id'      => $user->id,
            'is_new_user'  => $newUser,
        ];

        $responseArray = apiResponse("Success", '', false, $data, 200, "Sign Up", "User Sign up successfully");
        return response()->json($responseArray, 200);
    }

    public function otpVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'otp'    => ['required'],
        ], [
            'mobile.regex' => 'Mobile number must be 10 digits and start with 6, 7, 8, or 9.',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, "OTP Verification");
            return response()->json($responseArray, 422);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {
            $responseArray = apiResponse("Failed", '', false, '', 404, "OTP Verification", "User not found");
            return response()->json($responseArray, 404);
        }
        if ($user->otp != $request->otp) {
            $responseArray = apiResponse("Failed", '', false, '', 401, "OTP Verification", "Invalid OTP");
            return response()->json($responseArray, 401);

        }
        $user->mobile_verified_at = now();
        $tokenResult              = $user->createToken('MobileLoginToken');
        $token                    = $tokenResult->accessToken;
        $user->otp                = null;
        $user->save();

        $responseArray = apiResponse("Success", '', false, [
            'user_id' => $user->id,
        ], 200, "OTP Verification", "OTP verified successfully");
        return response()->json($responseArray, 200);
    }

    public function getUserDetails(Request $request)
    {
        $user                  = auth()->user();
        $getPeriods            = $user->periods()->latest()->first();
        $pregnancy_chance_days = [];
        $ovulation_status      = null;
        $upcoming_periods      = null;
        $pregnancy_chance      = "Low";

        if (! empty($getPeriods)) {
            $current     = \Carbon\Carbon::parse($getPeriods->ovulation);
            $fertile_end = \Carbon\Carbon::parse($getPeriods->fertile_window_end);
            while ($current <= $fertile_end) {
                $pregnancy_chance_days[] = $current->toDateString();
                $current->addDay();
            }

            $ovulationDate = \Carbon\Carbon::parse($getPeriods->ovulation)->startOfDay();
            $today         = now()->setTimezone('Asia/Kolkata')->startOfDay();

            if ($today->equalTo($ovulationDate)) {
                $ovulation_status = "On Date";
            } elseif ($today->lessThan($ovulationDate)) {
                $ovulation_status = $today->diffInDays($ovulationDate) . " days left";
            } else {
                $ovulation_status = $ovulationDate->diffInDays($today) . " days ago";
            }

            if ($getPeriods->next_period_date) {
                $nextPeriod = \Carbon\Carbon::parse($getPeriods->next_period_date)->startOfDay();
                if ($today->equalTo($nextPeriod)) {
                    $upcoming_periods = "On Date";
                } elseif ($today->lessThan($nextPeriod)) {
                    $upcoming_periods = $today->diffInDays($nextPeriod) . " days left";
                } else {
                    $upcoming_periods = $nextPeriod->diffInDays($today) . " days ago";
                }
            }

            // Pregnancy chance level
            $fertileStart = \Carbon\Carbon::parse($getPeriods->fertile_window_start)->startOfDay();
            $fertileEnd   = \Carbon\Carbon::parse($getPeriods->fertile_window_end)->startOfDay();

            if ($today->between($fertileStart, $fertileEnd)) {
                $pregnancy_chance = "High";
            } elseif (
                $today->diffInDays($fertileStart, false) >= -2 &&
                $today->diffInDays($fertileEnd, false) <= 2
            ) {
                $pregnancy_chance = "Medium";
            } else {
                $pregnancy_chance = "Low";
            }
        }

        if ($user->image) {
            $user->image = $user->getFirstMediaUrl('userprofile', 'thumb');
        } else {
            $user->image = null;
        }

        $hour = now()->setTimezone('Asia/Kolkata')->hour;

        if ($hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour < 17) {
            $greeting = 'Good Afternoon';
        } elseif ($hour < 21) {
            $greeting = 'Good Evening';
        } else {
            $greeting = 'Good Night';
        }

        $data = [
            'id'                    => $user->id,
            'greeting'              => $greeting,
            'terms_conditions'      => env('APP_URL') . '/termsAndCondition',
            'is_new_user'           => $user->mobile_verified_at ? 1 : 0,
            'name'                  => $user->name,
            'mobile'                => $user->mobile,
            'email'                 => $user->email,
            'image'                 => $user->image,
            'status'                => $user->status ? 'Active' : 'Inactive',
            'cus_id'                => $user->cus_id,
            'periods_last_date'     => $getPeriods ? $getPeriods->periods_last_date : null,
            'periods_end_date'      => $getPeriods ? $getPeriods->periods_end_date : null,
            'next_period_date'      => $getPeriods ? $getPeriods->next_period_date : null,
            'ovulation_date'        => $ovulation_status,
            'upcoming_periods'      => $upcoming_periods,
            'pregnancy_chance'      => $pregnancy_chance, // 🔹 Added pregnancy chance
            'fertile_window_start'  => $getPeriods ? $getPeriods->fertile_window_start : null,
            'fertile_window_end'    => $getPeriods ? $getPeriods->fertile_window_end : null,
            'cycle_length'          => $getPeriods ? $getPeriods->cycle_length : null,
            'period_length'         => $getPeriods ? $getPeriods->period_length : null,
            'flow'                  => $getPeriods ? $getPeriods->flow : null,
            'cramps_days'           => $getPeriods ? $getPeriods->cramps_days : null,
            'mood'                  => $getPeriods ? $getPeriods->mood : null,
            'symptoms'              => $getPeriods ? $getPeriods->symptoms : null,
            'period_type'           => $getPeriods ? $getPeriods->period_type : null,
            'period_color'          => $getPeriods ? $getPeriods->period_color : null,
            'period_intensity'      => $getPeriods ? $getPeriods->period_intensity : null,
            'period_pain'           => $getPeriods ? $getPeriods->period_pain : null,
            'period_flow'           => $getPeriods ? $getPeriods->period_flow : null,
            'period_duration'       => $getPeriods ? $getPeriods->period_duration : null,
            'period_notes'          => $getPeriods ? $getPeriods->period_notes : null,
            'pregnancy_chance_days' => $pregnancy_chance_days,
        ];

        $responseArray = apiResponse("Success", '', false, $data, 200, "Get User Details", "User details retrieved successfully");
        return response()->json($responseArray, 200);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->token()->revoke();
            $responseArray = apiResponse("Success", '', false, '', 200, "Logout", "User logged out successfully");
            return response()->json($responseArray, 200);
        } else {
            $responseArray = apiResponse("Failed", '', false, '', 401, "Logout", "Unauthorized");
            return response()->json($responseArray, 401);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        if (! $user) {
            $responseArray = apiResponse("Failed", '', false, '', 401, "Update Profile", "Unauthorized");
            return response()->json($responseArray, 401);
        }

        $validator = Validator::make($request->all(), [
            'mobile' => ['nullable', 'string', 'max:255'],
            'image'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, "Update Profile");
            return response()->json($responseArray, 422);
        }

        if ($request->has('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('userprofile');
        }
        if ($request->has('mobile')) {
            $user->mobile = $request->mobile;
        }
        $media = $user->getFirstMedia('userprofile');
        if ($media) {
            $user->image = $media->getUrl();
            $user->save();
        }

        $responseArray = apiResponse("Success", '', false, [
            'user_id' => $user->id,
            'image'   => $user->image,
            'mobile'  => $user->mobile,
        ], 200, "Update Profile", "Profile updated successfully");
        return response()->json($responseArray, 200);
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        if (! $user) {
            $responseArray = apiResponse("Failed", '', false, '', 401, "Delete Account", "Unauthorized");
            return response()->json($responseArray, 401);
        }
        $user->clearMediaCollection('userprofile');
        $user->delete();
        $responseArray = apiResponse("Success", '', false, '', 200, "Delete Account", "Account deleted successfully");
        return response()->json($responseArray, 200);
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
        ], [
            'mobile.regex' => 'Mobile number must be 10 digits and start with 6, 7, 8, or 9.',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, "Send OTP");
            return response()->json($responseArray, 422);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {
            $responseArray = apiResponse("Failed", '', false, '', 404, "Send OTP", "User not found");
            return response()->json($responseArray, 404);
        }

        if ($user->mobile_verified_at) {
            $responseArray = apiResponse("Failed", '', false, '', 409, "Send OTP", "Mobile number already verified");
            return response()->json($responseArray, 409);
        }
        $user->otp = sendSms($request->mobile);
        $user->mobile_verification_request_time  = now();
        $user->save();

        $responseArray = apiResponse("Success", '', false, '', 200, "Send OTP", "OTP sent successfully");
        return response()->json($responseArray, 200);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'otp'    => ['required', 'digits:6'],
        ], [
            'mobile.regex' => 'Mobile number must be 10 digits and start with 6, 7, 8, or 9.',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, "Verify OTP");
            return response()->json($responseArray, 422);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {
            $responseArray = apiResponse("Failed", '', false, '', 400, "Verify OTP", "User not found");
            return response()->json($responseArray, 400);
        }
        if ($user->otp != $request->otp) {
            $responseArray = apiResponse("Failed", '', false, '', 410, "Verify OTP", "Invalid OTP");
            return response()->json($responseArray, 410);

        }
        if ($user->mobile_request_verification_time && $user->mobile_request_verification_time->addMinutes(5) < now()) {
            $responseArray = apiResponse("Failed", '', false, '', 401, "Verify OTP", "OTP expired");
            return response()->json($responseArray, 401);
        }

        $user->mobile_verified_at = now();
        $user->otp                = null;
        $user->save();

        $responseArray = apiResponse("Success", '', false, '', 200, "Verify OTP", "OTP verified successfully");
        return response()->json($responseArray, 200);
    }
}
