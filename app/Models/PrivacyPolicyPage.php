<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicyPage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'last_updated' => 'date',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }
}
