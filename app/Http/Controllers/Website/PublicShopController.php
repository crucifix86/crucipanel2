<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Shop;

class PublicShopController extends Controller
{
    public function index()
    {
        // Get shop items using existing model
        $items = Shop::orderBy('id', 'desc')->paginate(20);
        
        // Get mask categories
        $masks = [
            1 => 'General',
            1 << 1 => 'Charms',
            1 << 2 => 'Fashion',
            1 << 3 => 'Mount & Pet',
            1 << 16 => 'War Avatar',
            1 << 17 => 'Equipment',
            1 << 18 => 'Hierogram & Tele',
            1 << 19 => 'Stone',
            1 << 21 => 'Flyer',
            1 << 22 => 'Genie',
            1 << 23 => 'Consumables',
            1 << 24 => 'Homestead',
            1 << 30 => 'Title',
            0 => 'All',
        ];

        return view('website.shop', [
            'items' => $items,
            'masks' => $masks
        ]);
    }
}