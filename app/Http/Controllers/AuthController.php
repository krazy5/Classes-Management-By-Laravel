<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
     // Show login form
    public function showLogin()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember'); // ✅ this captures the checkbox value (true/false)

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

     public function dashboard()
    {
        return view('index');
    }

    // Logout
    public function logout()
    {
    //     Auth::guard('admin')->logout(); // ✅ Logs out admin properly
    // return redirect()->route('login')->with('success', 'Logged out successfully!');

            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('success', 'Logged out');

    }

    public function showChangePasswordForm()
    {
        return view('login.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect.']);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password changed successfully!');
    }



}
