<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ IMPORTANT: Add this!

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // ✅ TRADITIONAL FORM - REDIRECT TO DASHBOARD
            return redirect('/dashboard'); // Dito na magde-decide ang routes kung saan i-redirect
        }

        // Authentication failed - RETURN BACK TO LOGIN PAGE WITH ERRORS
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}