<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'is_premium', 'premium_since', 'premium_expires',
        'avatar', 'bio',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'premium_since'     => 'datetime',
        'premium_expires'   => 'datetime',
        'is_premium'        => 'boolean',
        'password'          => 'hashed',
    ];

    // ── Helpers ──────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPro(): bool
    {
        return $this->is_premium
            && $this->premium_expires
            && $this->premium_expires->isFuture();
    }

    // ── Relationships ─────────────────────────────────────

    public function tools()
    {
        return $this->hasMany(Tool::class, 'created_by');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    public function followedCategories()
    {
        return $this->belongsToMany(Category::class, 'category_follows');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}