<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\API;
use App\Models\Faction;
use App\Models\FactionIcon;
use App\Models\FactionIconSetting;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class FactionIconController extends Controller
{
    /**
     * Display faction icon upload page
     */
    public function index()
    {
        $settings = FactionIconSetting::getSettings();
        
        if (!$settings->enabled) {
            return redirect()->route('app.dashboard')
                ->with('error', __('Faction icon upload is currently disabled.'));
        }
        
        $user = Auth::user();
        
        // Get user's characters via API
        $characters = $user->roles();
        
        // Debug: Log what we're getting
        \Log::info('Faction Icons Debug - User ID: ' . $user->ID);
        \Log::info('Faction Icons Debug - Characters: ' . json_encode($characters));
        
        // Extract character IDs - check both 'id' and 'roleid' keys
        $characterIds = [];
        foreach ($characters as $char) {
            if (isset($char['id'])) {
                $characterIds[] = $char['id'];
            } elseif (isset($char['roleid'])) {
                $characterIds[] = $char['roleid'];
            }
        }
        
        \Log::info('Faction Icons Debug - Character IDs: ' . json_encode($characterIds));
        
        // Get all factions where user is a master
        $factions = collect();
        
        if (!empty($characterIds)) {
            $factions = DB::table('pwp_factions')
                ->select('id', 'name', 'master', 'members')
                ->whereIn('master', $characterIds)
                ->get();
        }
            
        \Log::info('Faction Icons Debug - Factions found: ' . $factions->count());
        
        // Also log a sample faction to see the master field
        if ($factions->isNotEmpty()) {
            \Log::info('Faction Icons Debug - Sample faction: ' . json_encode($factions->first()));
        }
            
        // Get existing icon submissions
        $iconSubmissions = FactionIcon::whereIn('faction_id', $factions->pluck('id'))
            ->with('uploader', 'approver')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('front.faction-icons.index', compact('settings', 'factions', 'iconSubmissions'));
    }
    
    /**
     * Upload a faction icon
     */
    public function upload(Request $request)
    {
        $settings = FactionIconSetting::getSettings();
        
        if (!$settings->enabled) {
            return response()->json(['error' => __('Faction icon upload is currently disabled.')], 403);
        }
        
        // Validate the request
        $request->validate([
            'faction_id' => 'required|integer',
            'icon' => [
                'required',
                'image',
                'mimes:' . implode(',', $settings->allowed_formats),
                'max:' . ($settings->max_file_size / 1024), // Convert to KB for Laravel
            ],
        ]);
        
        $user = Auth::user();
        $factionId = $request->faction_id;
        
        // Get user's characters via API
        $characters = $user->roles();
        $characterIds = array_column($characters, 'id');
        
        // Verify user is faction master
        $isMaster = DB::table('pwp_factions')
            ->where('id', $factionId)
            ->whereIn('master', $characterIds)
            ->exists();
            
        if (!$isMaster) {
            return response()->json(['error' => __('You must be the faction master to upload an icon.')], 403);
        }
        
        // Check for existing pending submission
        $existingPending = FactionIcon::where('faction_id', $factionId)
            ->where('status', 'pending')
            ->where('server_id', config('pw-config.server_id', 1))
            ->exists();
            
        if ($existingPending) {
            return response()->json(['error' => __('You already have a pending icon submission for this faction.')], 400);
        }
        
        // Process the image
        $file = $request->file('icon');
        $image = Image::make($file);
        
        // Resize to exact dimensions
        $image->fit($settings->icon_size, $settings->icon_size);
        
        // Generate filename
        $filename = 'faction_' . $factionId . '_' . time() . '.png';
        $path = 'faction-icons/' . $filename;
        
        // Save to storage
        Storage::disk('public')->put($path, $image->encode('png'));
        
        // Create database record
        $factionIcon = FactionIcon::create([
            'faction_id' => $factionId,
            'server_id' => config('pw-config.server_id', 1),
            'icon_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'status' => $settings->require_approval ? 'pending' : 'approved',
            'uploaded_by' => $user->ID,
            'cost_virtual' => $settings->cost_virtual,
            'cost_gold' => $settings->cost_gold,
            'payment_processed' => false,
        ]);
        
        // If auto-approve is enabled and user has sufficient funds, process payment
        if (!$settings->require_approval) {
            $this->processPayment($factionIcon);
        }
        
        return response()->json([
            'success' => true,
            'message' => $settings->require_approval 
                ? __('Your faction icon has been submitted for approval.')
                : __('Your faction icon has been uploaded successfully.'),
            'icon_url' => $factionIcon->getIconUrl(),
        ]);
    }
    
    /**
     * Process payment for faction icon
     */
    private function processPayment(FactionIcon $factionIcon)
    {
        if ($factionIcon->payment_processed) {
            return false;
        }
        
        $user = Auth::user();
        
        // Check if user has sufficient funds
        $hasVirtual = true;
        $hasGold = true;
        
        if ($factionIcon->cost_virtual > 0) {
            $hasVirtual = $user->money >= $factionIcon->cost_virtual;
        }
        
        if ($factionIcon->cost_gold > 0) {
            // Get the faction to find the master character ID
            $faction = DB::table('pwp_factions')
                ->where('id', $factionIcon->faction_id)
                ->first();
                
            if ($faction) {
                // Get master character from players table
                $masterCharacter = Player::where('id', $faction->master)->first();
            } else {
                $masterCharacter = null;
            }
                
            if ($masterCharacter) {
                $hasGold = $masterCharacter->money >= $factionIcon->cost_gold;
            } else {
                $hasGold = false;
            }
        }
        
        if (!$hasVirtual || !$hasGold) {
            return false;
        }
        
        // Process payment
        DB::transaction(function () use ($factionIcon, $user) {
            if ($factionIcon->cost_virtual > 0) {
                $user->decrement('money', $factionIcon->cost_virtual);
            }
            
            if ($factionIcon->cost_gold > 0) {
                // Get the faction to find the master character ID
                $faction = DB::table('pwp_factions')
                    ->where('id', $factionIcon->faction_id)
                    ->first();
                    
                if ($faction) {
                    // Get master character from players table
                    $masterCharacter = Player::where('id', $faction->master)->first();
                } else {
                    $masterCharacter = null;
                }
                    
                if ($masterCharacter) {
                    $masterCharacter->decrement('money', $factionIcon->cost_gold);
                }
            }
            
            $factionIcon->update(['payment_processed' => true]);
        });
        
        return true;
    }
    
    /**
     * Cancel a pending icon submission
     */
    public function cancel($id)
    {
        $user = Auth::user();
        
        $factionIcon = FactionIcon::where('id', $id)
            ->where('uploaded_by', $user->ID)
            ->where('status', 'pending')
            ->firstOrFail();
        
        // Delete the file
        if ($factionIcon->icon_path) {
            Storage::disk('public')->delete($factionIcon->icon_path);
        }
        
        // Delete the record
        $factionIcon->delete();
        
        return redirect()->back()->with('success', __('Icon submission cancelled successfully.'));
    }
}