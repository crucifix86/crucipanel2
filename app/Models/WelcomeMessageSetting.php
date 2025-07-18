<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeMessageSetting extends Model
{
    protected $fillable = [
        'enabled',
        'subject',
        'message',
        'reward_enabled',
        'reward_type',
        'reward_amount',
    ];
    
    protected $casts = [
        'enabled' => 'boolean',
        'reward_enabled' => 'boolean',
        'reward_amount' => 'integer',
    ];
}