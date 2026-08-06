<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutPage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'history_gallery' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function getHistoryImageUrlAttribute(): ?string
    {
        return $this->history_image_path ? Storage::disk('public')->url($this->history_image_path) : null;
    }

    public function getHistoryGalleryUrlsAttribute(): array
    {
        return collect($this->history_gallery ?? [])
            ->filter(fn ($item) => ! empty($item['path']))
            ->map(fn ($item) => [
                'url' => Storage::disk('public')->url($item['path']),
                'caption' => $item['caption'] ?? null,
            ])
            ->values()
            ->all();
    }
}
