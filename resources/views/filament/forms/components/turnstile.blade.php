@php
    $siteKey = config('services.turnstile.site_key');
@endphp

@if ($siteKey)
    <div
        wire:ignore
        x-data="{}"
        x-init="
            window.onTurnstileVerified = (token) => {
                $wire.set('data.turnstile_token', token);
            };
        "
    >
        <div class="cf-turnstile" data-sitekey="{{ $siteKey }}" data-callback="onTurnstileVerified"></div>
    </div>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endif
