<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagingSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'messaging_enabled',
        'profile_wall_enabled',
        'message_rate_limit',
        'wall_message_rate_limit',
    ];

    protected $casts = [
        'messaging_enabled' => 'boolean',
        'profile_wall_enabled' => 'boolean',
        'message_rate_limit' => 'integer',
        'wall_message_rate_limit' => 'integer',
    ];

    /**
     * Get the current settings instance
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'messaging_enabled' => true,
            'profile_wall_enabled' => true,
            'message_rate_limit' => 10,
            'wall_message_rate_limit' => 5,
        ]);
    }
}
