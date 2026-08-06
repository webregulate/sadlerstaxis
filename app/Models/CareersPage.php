<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareersPage extends Model
{
    protected $guarded = ['id'];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function applicationForm()
    {
        return $this->belongsTo(Form::class, 'application_form_id');
    }
}
