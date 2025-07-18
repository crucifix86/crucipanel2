<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Faction;

class PublicRankingsController extends Controller
{
    public function index()
    {
        // Debug: First check if there are ANY players in the table
        $totalPlayers = Player::count();
        $totalFactions = Faction::count();
        
        // Get top 20 players by level using existing scope
        $topPlayers = Player::subtype('level')->limit(20)->get();

        // Get top 20 players by PvP kills using existing scope
        $topPvPPlayers = Player::subtype('pvp')
            ->where('pk_count', '>', 0)
            ->limit(20)
            ->get();

        // Get top 10 factions by level using existing scope
        $topFactions = Faction::with('icon')->subtype('level')->limit(10)->get();
        
        // Debug: Log the counts
        \Log::info('Rankings Debug - Total in DB: Players: ' . $totalPlayers . ', Factions: ' . $totalFactions);
        \Log::info('Rankings Debug - After filters: Players: ' . $topPlayers->count() . ', PvP: ' . $topPvPPlayers->count() . ', Factions: ' . $topFactions->count());
        
        // If no filtered results but there are players, try without the subtype scope
        if ($topPlayers->count() == 0 && $totalPlayers > 0) {
            $topPlayers = Player::orderBy('level', 'desc')->limit(20)->get();
            \Log::info('Rankings Debug - Used direct query, found: ' . $topPlayers->count());
        }

        return view('website.rankings', [
            'topPlayers' => $topPlayers,
            'topPvPPlayers' => $topPvPPlayers,
            'topFactions' => $topFactions
        ]);
    }
}