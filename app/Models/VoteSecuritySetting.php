<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteSecuritySetting extends Model
{
    protected $fillable = [
        'ip_limit_enabled',
        'max_votes_per_ip_daily',
        'max_votes_per_ip_per_site',
        'account_restrictions_enabled',
        'min_account_age_days',
        'min_character_level',
        'require_email_verified',
        'bypass_in_test_mode'
    ];

    protected $casts = [
        'ip_limit_enabled' => 'boolean',
        'account_restrictions_enabled' => 'boolean',
        'require_email_verified' => 'boolean',
        'bypass_in_test_mode' => 'boolean',
        'max_votes_per_ip_daily' => 'integer',
        'max_votes_per_ip_per_site' => 'integer',
        'min_account_age_days' => 'integer',
        'min_character_level' => 'integer'
    ];

    /**
     * Get the current settings (singleton pattern)
     */
    public static function getSettings()
    {
        return static::firstOrCreate([
            'id' => 1
        ], [
            'ip_limit_enabled' => true,
            'max_votes_per_ip_daily' => 2,
            'max_votes_per_ip_per_site' => 1,
            'account_restrictions_enabled' => true,
            'min_account_age_days' => 7,
            'min_character_level' => 0,
            'require_email_verified' => true,
            'bypass_in_test_mode' => true
        ]);
    }

    /**
     * Check if restrictions should be bypassed
     */
    public static function shouldBypass()
    {
        $settings = static::getSettings();
        return $settings->bypass_in_test_mode && (config('arena.test_mode') || config('arena.test_mode_clear_timer'));
    }
}