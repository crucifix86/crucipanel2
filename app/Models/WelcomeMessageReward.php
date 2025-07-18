<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeMessageReward extends Model
{
    protected $fillable = [
        'user_id',
        'message_id',
        'reward_type',
        'reward_amount',
        'claimed_at',
    ];
    
    protected $casts = [
        'claimed_at' => 'datetime',
        'reward_amount' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }
    
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}