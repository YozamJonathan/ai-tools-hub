<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'tool_id', 'body', 'status'];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function user() { return $this->belongsTo(User::class); }
    public function tool() { return $this->belongsTo(Tool::class); }
}