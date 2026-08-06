<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'fields' => 'array',
    ];

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function renderTemplate(?string $template, array $data): string
    {
        if (! $template) {
            return '';
        }

        return preg_replace_callback('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', function (array $matches) use ($data) {
            return $data[$matches[1]] ?? '';
        }, $template);
    }
}
