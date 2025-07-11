<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Faction;

class PublicRankingsController extends Controller
{
    public function index()
    {
        // Get top 20 players by level using existing scope
        $topPlayers = Player::subtype('level')->limit(20)->get();

        // Get top 20 players by PvP kills using existing scope
        $topPvPPlayers = Player::subtype('pvp')
            ->where('pk_count', '>', 0)
            ->limit(20)
            ->get();

        // Get top 10 factions by level using existing scope
        $topFactions = Faction::subtype('level')->limit(10)->get();
        
        // Debug: Log the counts
        \Log::info('Rankings Debug: Players: ' . $topPlayers->count() . ', PvP: ' . $topPvPPlayers->count() . ', Factions: ' . $topFactions->count());

        return view('website.rankings', [
            'topPlayers' => $topPlayers,
            'topPvPPlayers' => $topPvPPlayers,
            'topFactions' => $topFactions
        ]);
    }
}