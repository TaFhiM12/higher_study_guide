<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Point to your login view
    }

    /**
     * Handle the login process.
     */
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log in the user
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Redirect based on role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'agency') {
                return redirect()->route('agency.dashboard');
            } elseif ($role === 'student') {
                return redirect()->route('student.dashboard');
            }

            // Default fallback if role is not recognized
            Auth::logout();
            return back()->withErrors(['error' => 'Unauthorized role. Please contact support.']);
        }

        // If authentication fails
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    /**
     * Log the user out.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home.index')->with('success', 'You have been logged out.');
    }



    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string', // Password confirmation
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Proceed with user creation
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>$request->role,
        ]);
    
        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'current_institution' => $request->current_institution,
            ]);
        } elseif ($request->role === 'agency') {
            Agency::create([
                'user_id' => $user->id,
                'website' => $request->website,
                'TIN' => $request->tin,
                'address' => $request->address,
            ]);
        }
    
        return redirect()->route('home.index')->with('success', 'Signup successful. Please login.');
    }
    
public function showSignup(){
    return view('sign_up');
}
}
