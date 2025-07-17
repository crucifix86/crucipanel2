<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_user_id',
        'sender_id',
        'message',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Get the user whose profile this message is on
     */
    public function profileUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'profile_user_id', 'ID');
    }

    /**
     * Get the sender of the message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'ID');
    }

    /**
     * Scope for visible messages
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
