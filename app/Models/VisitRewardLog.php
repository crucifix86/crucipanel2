<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VisitRewardLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'reward_amount',
        'reward_type'
    ];

    protected $casts = [
        'reward_amount' => 'integer'
    ];

    /**
     * Check if user can claim reward
     */
    public function scopeCanClaim($query, Request $request, $user_id, $cooldown_hours)
    {
        return $query
            ->where('user_id', $user_id)
            ->where('created_at', '>=', Carbon::now()->subHours($cooldown_hours))
            ->doesntExist();
    }

    /**
     * Get last claim for user
     */
    public function scopeLastClaim($query, $user_id)
    {
        return $query
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }
}
