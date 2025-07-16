<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRecord; // Or your Student model
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    //
     public function showLoginForm()
    {
        return view('student.login'); // Create this Blade view
    }

    public function login(Request $request)
    {
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            //return "<h1>student ka login hua</h1>";
             return redirect()->route('student.dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
    // public function showRegisterForm()
    // {
    //     return view('student.register'); // Create this Blade view
    // }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'email'    => 'required|email|unique:users,email', // Change table if using Student model
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     // Use Student model if applicable
    //     $user = User::create([
    //         'name'     => $request->name,
    //         'email'    => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     Auth::login($user);

    //     return redirect('/student/dashboard');
    // }

    public function logout()
    {
        // Auth::logout();
        // return redirect()->route('student.login');
         Auth::guard('student')->logout();
         return redirect()->route('login')->with('success', 'Logged out');
    }

    public function showChangePasswordForm()
    {
        return view('login.change_password_student');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $admin = Auth::guard('student')->user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect.']);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password changed successfully!');
    }

}
