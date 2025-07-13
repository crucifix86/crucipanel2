<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function checkAuth(Request $request)
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_name' => Auth::user() ? Auth::user()->name : null,
            'session_id' => session()->getId(),
            'session_driver' => config('session.driver'),
            'request_headers' => $request->headers->all()
        ]);
    }
}