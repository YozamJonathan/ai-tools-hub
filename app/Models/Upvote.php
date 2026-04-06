<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
    protected $fillable = ['user_id', 'tool_id'];

    public function user() { return $this->belongsTo(User::class); }
    public function tool() { return $this->belongsTo(Tool::class); }
}