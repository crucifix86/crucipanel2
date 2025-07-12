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
        $membersList = [];
        
        foreach ($users as $user) {
            if ($user->isGamemaster() || $user->isAdministrator()) {
                $gms[] = $user;
            } else {
                $membersList[] = $user;
            }
        }
        
        // Paginate members manually for large lists
        $page = request()->get('page', 1);
        $perPage = 100; // Show 100 members per page
        $offset = ($page - 1) * $perPage;
        
        $members = array_slice($membersList, $offset, $perPage);
        $totalMembers = count($membersList);
        $totalPages = ceil($totalMembers / $perPage);
        
        return view('website.members', compact('gms', 'members', 'totalMembers', 'totalPages', 'page'));
    }
}