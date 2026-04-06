<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'category_follows');
    }
}
