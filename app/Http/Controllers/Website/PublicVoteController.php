<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\VoteSite;

class PublicVoteController extends Controller
{
    public function index()
    {
        // Get all active vote sites
        $sites = VoteSite::all();
        
        return view('website.vote', [
            'sites' => $sites
        ]);
    }
}