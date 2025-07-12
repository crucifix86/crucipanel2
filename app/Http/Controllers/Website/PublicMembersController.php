<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PublicMembersController extends Controller
{
    public function index()
    {
        // Get all users with their role (GM status)
        $users = User::orderBy('created_at', 'desc')->get();
        
        // Separate GMs and regular members
        $gms = [];
        $members = [];
        
        foreach ($users as $user) {
            if ($user->isGamemaster() || $user->isAdministrator()) {
                $gms[] = $user;
            } else {
                $members[] = $user;
            }
        }
        
        return view('website.members', compact('gms', 'members'));
    }
}