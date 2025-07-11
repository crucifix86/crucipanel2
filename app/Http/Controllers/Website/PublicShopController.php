<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class PublicShopController extends Controller
{
    public function index(Request $request)
    {
        // Get shop items - check if filtering by mask
        $mask = $request->get('mask', null);
        
        if ($mask !== null) {
            $items = Shop::where('mask', $mask)->orderBy('id', 'desc')->paginate(20);
        } else {
            $items = Shop::orderBy('id', 'desc')->paginate(20);
        }
        
        // Get mask categories for navigation
        $categories = [
            ['mask' => null, 'name' => 'All Items', 'icon' => '🛍️'],
            ['mask' => 1, 'name' => 'Weapons', 'icon' => '⚔️'],
            ['mask' => 2, 'name' => 'Helmet', 'icon' => '🪖'],
            ['mask' => 4, 'name' => 'Necklace', 'icon' => '📿'],
            ['mask' => 8, 'name' => 'Robe', 'icon' => '👘'],
            ['mask' => 16, 'name' => 'Chest', 'icon' => '🛡️'],
            ['mask' => 32, 'name' => 'Belt', 'icon' => '🎗️'],
            ['mask' => 64, 'name' => 'Leg', 'icon' => '👖'],
            ['mask' => 128, 'name' => 'Feet', 'icon' => '👢'],
            ['mask' => 256, 'name' => 'Arms', 'icon' => '💪'],
            ['mask' => 1536, 'name' => 'Ring', 'icon' => '💍'],
            ['mask' => 4096, 'name' => 'Mount', 'icon' => '🐴'],
            ['mask' => 8192, 'name' => 'Fashion Chest', 'icon' => '👗'],
            ['mask' => 16384, 'name' => 'Fashion Leg', 'icon' => '👖'],
            ['mask' => 32768, 'name' => 'Fashion Feet', 'icon' => '👠'],
            ['mask' => 65536, 'name' => 'Fashion Arms', 'icon' => '🧤'],
            ['mask' => 262144, 'name' => 'Hierogram', 'icon' => '📜'],
            ['mask' => 524288, 'name' => 'Tele/Stone', 'icon' => '💎'],
            ['mask' => 1048576, 'name' => 'HP Charm', 'icon' => '❤️'],
            ['mask' => 2097152, 'name' => 'MP Charm', 'icon' => '💙'],
            ['mask' => 0, 'name' => 'Other', 'icon' => '📦'],
        ];

        return view('website.shop', [
            'items' => $items,
            'categories' => $categories,
            'currentMask' => $mask
        ]);
    }
}