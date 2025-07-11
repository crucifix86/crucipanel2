<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Faction;

class PublicRankingsController extends Controller
{
    public function index()
    {
        // Get top 20 players by level
        $topPlayers = Player::orderBy('level', 'desc')
            ->orderBy('exp', 'desc')
            ->limit(20)
            ->get();

        // Get top 20 players by PvP kills
        $topPvPPlayers = Player::orderBy('pk_count', 'desc')
            ->where('pk_count', '>', 0)
            ->limit(20)
            ->get();

        // Get top 10 factions by level
        $topFactions = Faction::orderBy('level', 'desc')
            ->limit(10)
            ->get();

        return view('website.rankings', [
            'topPlayers' => $topPlayers,
            'topPvPPlayers' => $topPvPPlayers,
            'topFactions' => $topFactions
        ]);
    }
}