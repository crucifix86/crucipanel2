<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreLoginController extends Controller
{
    /**
     * Show the pre-login page
     */
    public function show()
    {
        // If user is already authenticated, redirect to dashboard
        if (auth()->check()) {
            return redirect()->route('app.dashboard');
        }

        // Check if user has already passed pre-login in this session
        if (session('pre_login_passed')) {
            return redirect()->route('login');
        }

        return view('auth.pre-login');
    }

    /**
     * Handle the pre-login form submission
     */
    public function submit(Request $request)
    {
        // Since the pre-login page IS the login page, we don't need a separate submit
        // This method is here in case we need it later
        return redirect()->route('login');
    }
}