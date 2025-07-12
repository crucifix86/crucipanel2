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
        $users = User::orderBy('created_at', 'desc')->get();
        
        // If searching, filter users by username, truename, or character names
        if ($search) {
            $users = $users->filter(function($user) use ($search) {
                // Check username and truename
                if (stripos($user->name, $search) !== false || 
                    stripos($user->truename ?? '', $search) !== false) {
                    return true;
                }
                
                // Check character names
                $characters = $user->roles();
                foreach ($characters as $character) {
                    if (stripos($character['name'] ?? '', $search) !== false) {
                        return true;
                    }
                }
                
                return false;
            });
        }
        
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