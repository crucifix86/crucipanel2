<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pwp_votelogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'ip_address', 'reward', 'site_id'];

    public function scopeRecent($query, Request $request, VoteSite $site)
    {
        return $query
            ->where('site_id', $site->id)
            ->where('user_id', Auth::user()->ID)
            ->where('ip_address', $request->ip())
            ->where('created_at', '>=', Carbon::now()->subHours($site->hour_limit));
    }

    public function scopeOnCooldown($query, Request $request, $id)
    {
        return $query
            ->where('ip_address', $request->ip())
            ->where('user_id', Auth::user()->ID)
            ->where('site_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(1);
    }

    /**
     * Count votes from a specific IP today
     */
    public function scopeFromIpToday($query, $ip)
    {
        return $query
            ->where('ip_address', $ip)
            ->whereDate('created_at', Carbon::today());
    }

    /**
     * Count votes from a specific IP for a specific site today
     */
    public function scopeFromIpForSiteToday($query, $ip, $siteId)
    {
        return $query
            ->where('ip_address', $ip)
            ->where('site_id', $siteId)
            ->whereDate('created_at', Carbon::today());
    }

    /**
     * Check if IP has reached daily limit
     */
    public static function ipReachedDailyLimit($ip)
    {
        $settings = VoteSecuritySetting::getSettings();
        
        if (!$settings->ip_limit_enabled || VoteSecuritySetting::shouldBypass()) {
            return false;
        }

        $votesToday = static::fromIpToday($ip)->count();
        return $votesToday >= $settings->max_votes_per_ip_daily;
    }

    /**
     * Check if IP has reached limit for specific site
     */
    public static function ipReachedSiteLimit($ip, $siteId)
    {
        $settings = VoteSecuritySetting::getSettings();
        
        if (!$settings->ip_limit_enabled || VoteSecuritySetting::shouldBypass()) {
            return false;
        }

        $votesForSite = static::fromIpForSiteToday($ip, $siteId)->count();
        return $votesForSite >= $settings->max_votes_per_ip_per_site;
    }
}
