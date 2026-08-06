<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    protected $guarded = ['id'];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function contactForm()
    {
        return $this->belongsTo(Form::class, 'contact_form_id');
    }
}
