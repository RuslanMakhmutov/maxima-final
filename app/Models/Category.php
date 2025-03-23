<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
    ];

    use HasFactory;
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
