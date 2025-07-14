<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitRewardSetting extends Model
{
    protected $fillable = [
        'enabled',
        'reward_amount',
        'reward_type',
        'cooldown_hours',
        'title',
        'description'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'reward_amount' => 'integer',
        'cooldown_hours' => 'integer'
    ];
}
