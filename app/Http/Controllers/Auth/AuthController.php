<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

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
            'mobile' => 'required|digits:10',
            'password' => 'required|min:6',
        ]);

        // Attempt to login
        $credentials = [
            'mobile' => $request->mobile,
            'password' => $request->password
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
}
