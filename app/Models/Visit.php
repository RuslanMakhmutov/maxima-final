<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    /**
     * Get the parent visitable model (Post or Category).
     */
    public function visitable()
    {
        return $this->morphTo();
    }
}
