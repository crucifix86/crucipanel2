<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use hrace009\PerfectWorldAPI\API;
use App\Models\Faction;
use App\Models\FactionIcon;
use App\Models\FactionIconSetting;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image; // Not installed

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
            // First, let's see if there are ANY factions and what the master values look like
            $sampleFactions = DB::table('pwp_factions')
                ->select('id', 'name', 'master')
                ->limit(5)
                ->get();
            \Log::info('Faction Icons Debug - Sample factions from DB: ' . json_encode($sampleFactions));
            
            // Check what the actual data type and format of master field is
            $rawQuery = DB::table('pwp_factions')
                ->select(DB::raw('id, name, master, HEX(master) as master_hex, CAST(master as UNSIGNED) as master_int'))
                ->where('name', 'LIKE', '%' . substr($characters[0]['name'] ?? 'unknown', 0, 3) . '%')
                ->limit(5)
                ->get();
            \Log::info('Faction Icons Debug - Raw master field analysis: ' . json_encode($rawQuery));
            
            // Now check for this user's factions
            $factions = DB::table('pwp_factions')
                ->select('id', 'name', 'master', 'members')
                ->whereIn('master', $characterIds)
                ->get();
                
            // Also check if any faction has master = 1024 specifically
            $directCheck = DB::table('pwp_factions')
                ->select('id', 'name', 'master', 'members')
                ->where('master', 1024)
                ->first();
            \Log::info('Faction Icons Debug - Direct check for master=1024: ' . json_encode($directCheck));
            
            // If we found a faction in direct check but not in the main query, add it
            if ($directCheck && $factions->where('id', $directCheck->id)->isEmpty()) {
                $factions->push($directCheck);
                \Log::info('Faction Icons Debug - Added direct check faction to collection');
            }
            
            // Try different ways to match the master field
            if ($factions->isEmpty() && !empty($characterIds)) {
                foreach ($characterIds as $charId) {
                    $altCheck = DB::table('pwp_factions')
                        ->whereRaw('CAST(master as UNSIGNED) = ?', [$charId])
                        ->first();
                    if ($altCheck) {
                        \Log::info('Faction Icons Debug - Found faction with CAST for char ' . $charId . ': ' . json_encode($altCheck));
                        $factions->push($altCheck);
                    }
                }
            }
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
        
        \Log::info('Faction Icons Debug - Passing to view:', [
            'factions_count' => $factions->count(),
            'factions_data' => $factions->toArray(),
            'icon_submissions_count' => $iconSubmissions->count()
        ]);
        
        return view('front.faction-icons.index', compact('settings', 'factions', 'iconSubmissions'));
    }
    
    /**
     * Upload a faction icon
     */
    public function upload(Request $request)
    {
        \Log::info('Faction Icon Upload Started', ['user_id' => Auth::id()]);
        
        try {
            $settings = FactionIconSetting::getSettings();
            \Log::info('Settings loaded', ['enabled' => $settings->enabled]);
            
            if (!$settings->enabled) {
                return response()->json(['error' => __('Faction icon upload is currently disabled.')], 403);
            }
            
            // Log request data
            \Log::info('Request data', [
                'faction_id' => $request->faction_id,
                'has_file' => $request->hasFile('icon'),
                'file_info' => $request->hasFile('icon') ? [
                    'size' => $request->file('icon')->getSize(),
                    'mime' => $request->file('icon')->getMimeType(),
                    'extension' => $request->file('icon')->getClientOriginalExtension()
                ] : null
            ]);
            
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
            
            \Log::info('Validation passed');
            
            $user = Auth::user();
            $factionId = $request->faction_id;
            
            // Get user's characters via API
            $characters = $user->roles();
            $characterIds = array_column($characters, 'id');
            \Log::info('User characters', ['character_ids' => $characterIds]);
            
            // Check faction master
            $faction = DB::table('pwp_factions')
                ->where('id', $factionId)
                ->first();
            \Log::info('Faction data', ['faction' => $faction]);
            
            // Verify user is faction master
            $isMaster = DB::table('pwp_factions')
                ->where('id', $factionId)
                ->whereIn('master', $characterIds)
                ->exists();
                
            \Log::info('Master check', ['is_master' => $isMaster]);
                
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
        
            // Process the image without Intervention
            $file = $request->file('icon');
            \Log::info('Processing image', ['original_name' => $file->getClientOriginalName()]);
            
            // Check image dimensions
            list($width, $height) = getimagesize($file->getRealPath());
            if ($width != $settings->icon_size || $height != $settings->icon_size) {
                return response()->json(['error' => __('Image must be exactly :size x :size pixels.', ['size' => $settings->icon_size])], 400);
            }
            
            // Generate filename
            $filename = 'faction_' . $factionId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'faction-icons/' . $filename;
            
            // Ensure directory exists
            Storage::disk('public')->makeDirectory('faction-icons', 0755, true);
            
            // Save to storage
            Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
            \Log::info('Image saved', ['path' => $path]);
            
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
            
            \Log::info('Database record created', ['faction_icon_id' => $factionIcon->id, 'status' => $factionIcon->status]);
            
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
        } catch (\Exception $e) {
            \Log::error('Faction Icon Upload Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
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