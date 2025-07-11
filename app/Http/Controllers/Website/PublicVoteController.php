<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ArenaLogs;
use App\Models\VoteLog;
use App\Models\VoteSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicVoteController extends Controller
{
    public function index(Request $request)
    {
        // Redirect to the working dashboard vote page
        return redirect()->route('app.vote.index');
    }
}