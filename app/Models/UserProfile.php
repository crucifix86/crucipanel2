<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'public_bio',
        'public_discord',
        'public_website',
        'public_profile_enabled',
        'public_wall_enabled',
    ];

    protected $casts = [
        'public_profile_enabled' => 'boolean',
        'public_wall_enabled' => 'boolean',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }
}