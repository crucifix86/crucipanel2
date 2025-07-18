<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactionIcon extends Model
{
    protected $fillable = [
        'faction_id',
        'server_id',
        'icon_path',
        'original_filename',
        'status',
        'uploaded_by',
        'approved_by',
        'rejection_reason',
        'cost_virtual',
        'cost_gold',
        'payment_processed',
    ];
    
    protected $casts = [
        'payment_processed' => 'boolean',
    ];
    
    /**
     * Get the user who uploaded the icon
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'ID');
    }
    
    /**
     * Get the admin who approved/rejected the icon
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'ID');
    }
    
    /**
     * Get the faction this icon belongs to
     */
    public function faction()
    {
        return $this->belongsTo(Faction::class, 'faction_id', 'id');
    }
    
    /**
     * Scope for pending icons
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    /**
     * Scope for approved icons
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    /**
     * Check if the icon is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    /**
     * Check if the icon is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    
    /**
     * Check if the icon is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
    
    /**
     * Get the full URL to the icon
     */
    public function getIconUrl()
    {
        if (!$this->icon_path) {
            return null;
        }
        
        return asset('storage/' . $this->icon_path);
    }
}