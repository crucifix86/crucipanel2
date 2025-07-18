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
        'email_verification_enabled',
    ];
    
    protected $casts = [
        'enabled' => 'boolean',
        'reward_enabled' => 'boolean',
        'reward_amount' => 'integer',
        'email_verification_enabled' => 'boolean',
    ];
}