<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $fillable = [
        'user_id',
        'ip_address',
        'browser',
    ];

    /**
     * Get the parent visitable model (Post or Category).
     */
    public function visitable()
    {
        return $this->morphTo();
    }
}
