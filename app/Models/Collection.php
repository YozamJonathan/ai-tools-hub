<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collection extends Model
{
    protected $fillable = ['user_id', 'name', 'is_public', 'share_token'];

    protected $casts = ['is_public' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'collection_tool')
                    ->withPivot('added_at');
    }

    public function generateShareToken(): void
    {
        $this->update(['share_token' => Str::random(32), 'is_public' => true]);
    }
}