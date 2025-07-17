<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function balance(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = Auth::user();
        
        return response()->json([
            'money' => $user->money,
            'bonuses' => $user->bonuses,
            'currency_name' => config('pw-config.currency_name', 'Coins')
        ]);
    }
}