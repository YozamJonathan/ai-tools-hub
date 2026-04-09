<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'tool_id', 'message',
        'reply', 'is_priority', 'status', 'read_at',
    ];

    protected $casts = [
        'is_priority' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function tool() { return $this->belongsTo(Tool::class); }

    /**
     * Check if message has been read by user
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Check if message has a reply
     */
    public function hasReply(): bool
    {
        return $this->status === 'replied' && !empty($this->reply);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(): void
    {
        if (!$this->isRead() && $this->hasReply()) {
            $this->update(['read_at' => now()]);
        }
    }
}
