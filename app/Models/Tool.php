<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tool extends Model
{
    protected $fillable = [
        'name', 'slug', 'url', 'description', 'category_id',
        'created_by', 'status', 'is_featured', 'is_sponsored',
        'thumbnail', 'emoji', 'avg_rating', 'vote_count',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_sponsored' => 'boolean',
        'avg_rating'   => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tool) {
            $tool->slug = Str::slug($tool->name);
        });
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeTrending($query)
    {
        return $query->orderBy('vote_count', 'desc');
    }

    public function scopeNewThisWeek($query)
    {
        return $query->where('created_at', '>=', now()->subWeek());
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // ── Relationships ─────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ── Helpers ───────────────────────────────────────────

    public function recalculateRating(): void
    {
        $avg = $this->ratings()->avg('stars') ?? 0;
        $this->update(['avg_rating' => round($avg, 2)]);
    }
}