<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FactionIcon;
use App\Models\FactionIconSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FactionIconController extends Controller
{
    /**
     * Display faction icon management page
     */
    public function index()
    {
        $pendingIcons = FactionIcon::with(['faction', 'uploader'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $recentIcons = FactionIcon::with(['faction', 'uploader', 'approver'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->limit(50)
            ->get();
            
        $settings = FactionIconSetting::getSettings();
        
        return view('admin.faction-icons.index', compact('pendingIcons', 'recentIcons', 'settings'));
    }
    
    /**
     * Display faction icon settings page
     */
    public function settings()
    {
        $settings = FactionIconSetting::getSettings();
        return view('admin.faction-icons.settings', compact('settings'));
    }
    
    /**
     * Update faction icon settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
            'icon_size' => 'required|integer|min:16|max:128',
            'max_file_size' => 'required|integer|min:10240|max:5242880', // 10KB to 5MB
            'cost_virtual' => 'required|integer|min:0',
            'cost_gold' => 'required|integer|min:0',
            'require_approval' => 'required|boolean',
            'auto_deploy' => 'required|boolean',
            'allowed_formats' => 'required|array|min:1',
            'allowed_formats.*' => 'required|string|in:png,jpg,jpeg,gif',
        ]);
        
        $settings = FactionIconSetting::getSettings();
        $settings->update($request->all());
        
        return redirect()->route('admin.faction-icons.settings')
            ->with('success', __('Faction icon settings updated successfully!'));
    }
    
    /**
     * Approve a faction icon
     */
    public function approve($id)
    {
        $icon = FactionIcon::findOrFail($id);
        
        if (!$icon->isPending()) {
            return redirect()->back()->with('error', __('This icon has already been processed.'));
        }
        
        // Check if payment needs to be processed
        if (!$icon->payment_processed) {
            $paymentProcessed = $this->processPayment($icon);
            
            if (!$paymentProcessed) {
                return redirect()->back()->with('error', __('Cannot approve icon: User has insufficient funds.'));
            }
        }
        
        // Remove any existing approved icon for this faction
        $existingApproved = FactionIcon::where('faction_id', $icon->faction_id)
            ->where('server_id', $icon->server_id)
            ->where('status', 'approved')
            ->where('id', '!=', $icon->id)
            ->first();
            
        if ($existingApproved) {
            // Delete old icon file
            if ($existingApproved->icon_path) {
                Storage::disk('public')->delete($existingApproved->icon_path);
            }
            $existingApproved->delete();
        }
        
        // Approve the icon
        $icon->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
        ]);
        
        // Deploy to game server if auto-deploy is enabled
        $settings = FactionIconSetting::getSettings();
        if ($settings->auto_deploy) {
            $this->deployToGameServer($icon);
        }
        
        return redirect()->back()->with('success', __('Faction icon approved successfully!'));
    }
    
    /**
     * Reject a faction icon
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $icon = FactionIcon::findOrFail($id);
        
        if (!$icon->isPending()) {
            return redirect()->back()->with('error', __('This icon has already been processed.'));
        }
        
        // Delete the icon file
        if ($icon->icon_path) {
            Storage::disk('public')->delete($icon->icon_path);
        }
        
        // Reject the icon
        $icon->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejection_reason' => $request->reason,
        ]);
        
        return redirect()->back()->with('success', __('Faction icon rejected.'));
    }
    
    /**
     * Delete a faction icon
     */
    public function destroy($id)
    {
        $icon = FactionIcon::findOrFail($id);
        
        // Delete the icon file
        if ($icon->icon_path) {
            Storage::disk('public')->delete($icon->icon_path);
        }
        
        $icon->delete();
        
        return redirect()->back()->with('success', __('Faction icon deleted successfully.'));
    }
    
    /**
     * Process payment for faction icon
     */
    private function processPayment(FactionIcon $icon)
    {
        // This is similar to the front-end controller but called from admin
        $controller = new \App\Http\Controllers\Front\FactionIconController();
        $reflection = new \ReflectionMethod($controller, 'processPayment');
        $reflection->setAccessible(true);
        return $reflection->invoke($controller, $icon);
    }
    
    /**
     * Deploy icon to game server
     */
    private function deployToGameServer(FactionIcon $icon)
    {
        // This would contain the logic to deploy the icon to the game server
        // For now, we'll just mark it as deployed
        // In a real implementation, this might:
        // 1. Copy the icon to the game server's icon directory
        // 2. Update the game server's faction database
        // 3. Notify the game server to reload faction data
        
        // TODO: Implement actual deployment logic based on your game server setup
    }
}