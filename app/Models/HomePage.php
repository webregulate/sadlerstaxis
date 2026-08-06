<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomePage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'highlights' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->hero_image_path ? Storage::disk('public')->url($this->hero_image_path) : null;
    }
}
