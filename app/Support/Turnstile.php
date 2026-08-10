<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class Turnstile
{
    public static function isEnabled(): bool
    {
        return filled(config('services.turnstile.site_key')) && filled(config('services.turnstile.secret_key'));
    }

    public static function verify(?string $token, ?string $ip = null): bool
    {
        if (! static::isEnabled()) {
            // Not configured yet — don't block real submissions/logins over it.
            return true;
        }

        if (blank($token)) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $ip,
            ]);

            return (bool) $response->json('success');
        } catch (Throwable $e) {
            Log::error('Turnstile verification request failed: '.$e->getMessage());

            // Fail closed: if Cloudflare is unreachable, don't let a spam wave straight through.
            return false;
        }
    }
}
