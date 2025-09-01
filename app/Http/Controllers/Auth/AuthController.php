<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login'); // your login blade
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'mobile'   => 'required|digits:10',
            'password' => 'required|min:6',
        ]);

        // Attempt to login
        $credentials = [
            'mobile'   => $request->mobile,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/admin/dashboard')->with('success', 'Login successful');
        }

        // If failed
        return back()->withErrors([
            'mobile' => 'Invalid mobile number or password.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }

    public function termsAndConditions()
    {
        $settings = \DB::table('settings')->where('key', 'Terms-and-Conditions')->first();
        if (!empty($settings)) {
            $termsContent = $settings->value;
            $updatedAt    = $settings->updated_at ? \Carbon\Carbon::parse($settings->updated_at)->format('d M Y') : null;
            return view('admin.policy.terms', compact('termsContent', 'updatedAt'));
        }
        return view('admin.policy.terms');
    }

    public function privacyPolicy()
    {
        $settings = \DB::table('settings')->where('key', 'Privacy-Policy')->first();
        if (! empty($settings)) {
            $privacyContent = $settings->value;
            $updatedAt      = $settings->updated_at ? \Carbon\Carbon::parse($settings->updated_at)->format('d M Y') : null;
            return view('admin.policy.privacy', compact('privacyContent', 'updatedAt'));
        }
        return view('admin.policy.privacy');
    }

    public function settingList()
    {
        $settings = \DB::table('settings')->get();
        return view('admin.policy.index', compact('settings'));
    }

    public function policyEdit($key)
    {
        $setting = \DB::table('settings')->where('id', $key)->first();
        if (! $setting) {
            return redirect()->route('admin.settings.index')->with('error', 'Setting not found.');
        }
        return view('admin.policy.edit', compact('setting'));
    }

    public function policyUpdate(Request $request, $key)
    {
        $request->validate([
            'value' => 'required|string',
        ]);

        $setting = \DB::table('settings')->where('id', $key)->first();
        if (! $setting) {
            return redirect()->route('admin.settings.index')->with('error', 'Setting not found.');
        }

        \DB::table('settings')->where('id', $key)->update([
            'value'      => $request->value,
            'updated_at' => now(),
        ]);

        $message = $setting->key === 'Terms-and-Conditions' ? 'Terms and Conditions updated successfully.' : 'Privacy Policy updated successfully.';

        return redirect()->route('admin.settings.index')->with('success', $message);
    }
}
