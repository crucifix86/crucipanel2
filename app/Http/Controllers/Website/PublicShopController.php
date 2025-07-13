<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Voucher;
use App\Models\Service;
use Illuminate\Http\Request;

class PublicShopController extends Controller
{
    public function index(Request $request)
    {
        // Get current tab (items, vouchers, services)
        $tab = $request->get('tab', 'items');
        
        // Get search query
        $search = $request->get('search', '');
        
        // Initialize variables
        $items = collect();
        $vouchers = collect();
        $services = collect();
        
        // Get data based on active tab
        if ($tab === 'items' || $search) {
            // Get shop items - check if filtering by mask
            $mask = $request->get('mask', null);
            
            $itemsQuery = Shop::query();
            
            if ($search) {
                $itemsQuery->where(function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            
            if ($mask !== null && !$search) {
                $itemsQuery->where('mask', $mask);
            }
            
            $items = $itemsQuery->orderBy('id', 'desc')->paginate(20);
        }
        
        if ($tab === 'vouchers' || $search) {
            // Get vouchers
            $vouchersQuery = Voucher::query();
            
            if ($search) {
                $vouchersQuery->where('code', 'like', '%' . $search . '%');
            }
            
            $vouchers = $vouchersQuery->orderBy('id', 'desc')->get();
        }
        
        if ($tab === 'services' || $search) {
            // Get services
            $servicesQuery = Service::where('enabled', 1);
            
            if ($search) {
                $servicesQuery->where('key', 'like', '%' . $search . '%');
            }
            
            $services = $servicesQuery->orderBy('price', 'asc')->get();
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

        // Service icons
        $serviceInfo = [
            'broadcast' => ['icon' => '📢'],
            'virtual_to_cubi' => ['icon' => '💎'],
            'cultivation_change' => ['icon' => '🔮'],
            'gold_to_virtual' => ['icon' => '💰'],
            'level_up' => ['icon' => '⬆️'],
            'max_meridian' => ['icon' => '✨'],
            'reset_exp' => ['icon' => '🔄'],
            'reset_sp' => ['icon' => '🔄'],
            'reset_stash_password' => ['icon' => '🔓'],
            'teleport' => ['icon' => '🌟'],
        ];

        // Get voucher logs for authenticated users
        $voucherLogs = collect();
        if (auth()->check() && ($tab === 'vouchers' || $search)) {
            $voucherLogs = auth()->user()->voucher_logs()->with('voucher')->orderBy('created_at', 'desc')->get();
        }
        
        return view('website.shop', [
            'items' => $items,
            'vouchers' => $vouchers,
            'services' => $services,
            'categories' => $categories,
            'currentMask' => $mask ?? null,
            'tab' => $tab,
            'search' => $search,
            'serviceInfo' => $serviceInfo,
            'voucherLogs' => $voucherLogs
        ]);
    }
}