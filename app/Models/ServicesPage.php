<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesPage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'services' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }
}
