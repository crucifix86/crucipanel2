<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CheckPinController extends Controller
{
    public function checkPin(Request $request)
    {
        $username = $request->input('username');
        
        if (!$username) {
            return response()->json(['pin_required' => false]);
        }
        
        $user = User::where('name', $username)->orWhere('email', $username)->first();
        
        if (!$user) {
            return response()->json(['pin_required' => false]);
        }
        
        return response()->json([
            'pin_required' => $user->pin_enabled && $user->qq !== null
        ]);
    }
}