<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'message',
        'is_read',
        'parent_id',
        'deleted_by_sender',
        'deleted_by_recipient',
        'is_welcome_message',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'deleted_by_sender' => 'boolean',
        'deleted_by_recipient' => 'boolean',
        'is_welcome_message' => 'boolean',
    ];

    /**
     * Get the sender of the message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'ID');
    }

    /**
     * Get the recipient of the message
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id', 'ID');
    }

    /**
     * Get the parent message (for threading)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    /**
     * Get the replies to this message
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    /**
     * Scope for inbox messages
     */
    public function scopeInbox($query, $userId)
    {
        return $query->where('recipient_id', $userId)
                    ->where('deleted_by_recipient', false);
    }

    /**
     * Scope for sent messages
     */
    public function scopeSent($query, $userId)
    {
        return $query->where('sender_id', $userId)
                    ->where('deleted_by_sender', false);
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Get conversation thread
     */
    public function getThread()
    {
        if ($this->parent_id) {
            return $this->parent->getThread();
        }
        
        return $this->with(['replies.sender', 'replies.recipient'])
                    ->where('id', $this->id)
                    ->first();
    }
}
