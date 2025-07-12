<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Request;
use hrace009\PerfectWorldAPI\API;

class PublicMembersController extends Controller
{
    public function index(Request $request)
    {
        // Get search query
        $search = $request->get('search');
        
        // Get online characters list
        $api = new API();
        $onlineCharacters = [];
        if ($api->online) {
            $onlineList = $api->getOnlineList();
            foreach ($onlineList as $player) {
                $onlineCharacters[$player['roleid']] = true;
            }
        }
        
        // Get all users with their role (GM status)
        $usersQuery = User::query();
        
        if ($search) {
            $usersQuery->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('truename', 'like', '%' . $search . '%');
            });
        }
        
        $users = $usersQuery->orderBy('created_at', 'desc')->get();
        
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
        
        return view('website.members', compact('gms', 'members', 'totalMembers', 'totalPages', 'page', 'search', 'onlineCharacters'));
    }
}