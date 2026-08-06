<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'show_warning_banner' => 'boolean',
        'phone_areas' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? Storage::disk('public')->url($this->logo_path) : null;
    }
}
