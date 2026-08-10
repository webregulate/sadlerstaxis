<?php

namespace App\Filament\Pages\Auth;

use App\Support\Turnstile;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\View as FormView;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function getForms(): array
    {
        $forms = parent::getForms();

        if (Turnstile::isEnabled()) {
            $forms['form'] = $forms['form']->schema([
                ...$forms['form']->getComponents(),
                Hidden::make('turnstile_token'),
                FormView::make('filament.forms.components.turnstile'),
            ]);
        }

        return $forms;
    }

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
