<?php

namespace App\Filament\Pages\Auth;

use App\Support\Turnstile;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Components\Attributes\Exposed;
use Filament\Support\Components\Attributes\Unexposed;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    #[Unexposed]
    public function form(Schema $schema): Schema
    {
        $components = [
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ];

        if (Turnstile::isEnabled()) {
            $components[] = Hidden::make('turnstile_token');
            $components[] = View::make('filament.forms.components.turnstile');
        }

        return $schema->components($components);
    }

    #[Exposed]
    public function authenticate(): ?LoginResponse
    {
        if (Turnstile::isEnabled()) {
            $token = $this->form->getState()['turnstile_token'] ?? null;

            if (! Turnstile::verify($token, request()->ip())) {
                throw ValidationException::withMessages([
                    'data.email' => 'Security check failed — please try again.',
                ]);
            }
        }

        return parent::authenticate();
    }
}
