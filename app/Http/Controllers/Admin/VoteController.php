<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Models\VoteSite;
use App\Models\VoteSecuritySetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use App\Facades\LocalSettings;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sites = VoteSite::paginate();
        return view('admin.vote.index', [
            'sites' => $sites
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.vote.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VoteRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(VoteRequest $request)
    {
        VoteSite::create($request->all());
        return redirect(route('vote.index'))->with('success', __('vote.add_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param VoteSite $site
     * @return void
     */
    public function show(VoteSite $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VoteSite $site
     * @return Application|Factory|View
     */
    public function edit(VoteSite $site)
    {
        return view('admin.vote.edit', [
            'site' => $site
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param VoteSite $site
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, VoteSite $site)
    {
        $site->update($request->all());
        return redirect(route('vote.index'))->with('success', __('vote.edit.modify_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VoteSite $site
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(VoteSite $site)
    {
        $site->delete();
        return redirect(route('vote.index'))->with('success', __('vote.destroy_success'));
    }

    public function getArena()
    {
        return view('admin.vote.top100.index');
    }

    public function postArena(Request $request)
    {
        $status = $request->has('status');
        
        // Save to both config and local settings
        Config::write('arena.status', $status);
        LocalSettings::set('arena.status', $status);

        if ($status) {
            $configs = $request->validate([
                'username' => 'string|required',
                'reward' => 'numeric|required',
                'reward_type' => 'required',
                'time' => 'numeric|required'
            ]);
            
            // Save each config to both systems
            foreach ($configs as $config => $value) {
                Config::write('arena.' . $config, $value);
                LocalSettings::set('arena.' . $config, $value);
            }
            
            // Handle test mode settings
            $testMode = $request->has('test_mode');
            $testModeClearTimer = $request->has('test_mode_clear_timer');
            
            Config::write('arena.test_mode', $testMode);
            LocalSettings::set('arena.test_mode', $testMode);
            
            Config::write('arena.test_mode_clear_timer', $testModeClearTimer);
            LocalSettings::set('arena.test_mode_clear_timer', $testModeClearTimer);
            
            // Log test mode status
            if ($testMode || $testModeClearTimer) {
                \Log::warning('Arena Test Mode Enabled', [
                    'test_mode' => $testMode,
                    'test_mode_clear_timer' => $testModeClearTimer,
                    'enabled_by' => auth()->user()->name ?? 'Unknown'
                ]);
            }
        }
        
        // Clear and re-cache config after all writes are complete
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        
        // Simple redirect back with query parameter
        $url = url()->previous();
        if (strpos($url, '?') !== false) {
            $url .= '&saved=1';
        } else {
            $url .= '?saved=1';
        }
        
        return redirect($url);
    }
    
    /**
     * Show vote security settings page
     */
    public function getSecurity()
    {
        $settings = VoteSecuritySetting::getSettings();
        return view('admin.vote.security', compact('settings'));
    }
    
    /**
     * Update vote security settings
     */
    public function postSecurity(Request $request)
    {
        $settings = VoteSecuritySetting::getSettings();
        
        $validated = $request->validate([
            'ip_limit_enabled' => 'boolean',
            'max_votes_per_ip_daily' => 'required|integer|min:1|max:100',
            'max_votes_per_ip_per_site' => 'required|integer|min:1|max:10',
            'account_restrictions_enabled' => 'boolean',
            'min_account_age_days' => 'required|integer|min:0|max:365',
            'min_character_level' => 'required|integer|min:0|max:150',
            'require_email_verified' => 'boolean',
            'bypass_in_test_mode' => 'boolean'
        ]);
        
        // Convert checkboxes
        $validated['ip_limit_enabled'] = $request->has('ip_limit_enabled');
        $validated['account_restrictions_enabled'] = $request->has('account_restrictions_enabled');
        $validated['require_email_verified'] = $request->has('require_email_verified');
        $validated['bypass_in_test_mode'] = $request->has('bypass_in_test_mode');
        
        $settings->update($validated);
        
        // Simple redirect back with query parameter
        $url = url()->previous();
        if (strpos($url, '?') !== false) {
            $url .= '&saved=1';
        } else {
            $url .= '?saved=1';
        }
        
        return redirect($url);
    }
}
