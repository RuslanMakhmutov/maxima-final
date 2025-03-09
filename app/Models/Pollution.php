<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Pollution extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = [
        'coord',
        'dt',
        'main',
        'components',
    ];
}
