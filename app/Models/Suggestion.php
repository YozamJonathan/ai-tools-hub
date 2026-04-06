<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'user_id', 'tool_name', 'tool_url',
        'description', 'status', 'admin_note',
    ];

    public function user() { return $this->belongsTo(User::class); }
}