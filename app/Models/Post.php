<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'content',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'image_url'
    ];

    public function deleteImage(): void
    {
        if (!empty($this->image) && Storage::fileExists($this->image)) {
            Storage::delete($this->image);
        }
        $this->image = null;
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if (empty($attributes['image'])) {
                    return null;
                } elseif (str_starts_with($attributes['image'], 'http')) {
                    return $attributes['image'];
                } elseif (Storage::fileExists($attributes['image'])) {
                    return Storage::url($attributes['image']);
                }

                return null;
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
