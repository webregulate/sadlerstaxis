<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountsPage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'benefits' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    public function newAccountForm()
    {
        return $this->belongsTo(Form::class, 'new_account_form_id');
    }
}
