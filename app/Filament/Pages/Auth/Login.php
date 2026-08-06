<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\View as FormView;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function getForms(): array
    {
        $forms = parent::getForms();

        if (config('services.turnstile.site_key')) {
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
        $this->verifyTurnstile();

        return parent::authenticate();
    }

    protected function verifyTurnstile(): void
    {
        $secret = config('services.turnstile.secret_key');

        if (! $secret) {
            // Turnstile isn't configured yet — don't lock out logins over it.
            return;
        }

        $token = $this->form->getState()['turnstile_token'] ?? null;

        if (! $token) {
            throw ValidationException::withMessages([
                'data.email' => 'Please complete the security check.',
            ]);
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            throw ValidationException::withMessages([
                'data.email' => 'Security check failed — please try again.',
            ]);
        }
    }
}
