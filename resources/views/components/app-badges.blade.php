@props(['iosUrl' => null, 'androidUrl' => null])

@if ($iosUrl || $androidUrl)
    <div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-3']) }}>
        @if ($iosUrl)
            <a
                href="{{ $iosUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-2 rounded-xl border border-white/15 bg-black px-4 py-2 transition hover:bg-black/80"
            >
                <svg width="22" height="22" viewBox="0 0 24 24" fill="white" aria-hidden="true">
                    <path d="M16.365 1.43c0 1.14-.475 2.226-1.238 3.02-.822.85-2.16 1.51-3.24 1.42-.148-1.086.44-2.24 1.207-3.02.834-.85 2.276-1.49 3.27-1.42zM20.62 17.34c-.53 1.2-.78 1.74-1.46 2.79-.95 1.46-2.29 3.28-3.95 3.3-1.47.02-1.85-.96-3.85-.95-2 .01-2.42.97-3.9.95-1.66-.02-2.93-1.66-3.88-3.12-2.65-4.07-2.93-8.85-1.3-11.4C4.6 7.06 6.36 6 8.03 6c1.7 0 2.77 1 4.18 1 1.37 0 2.2-1 4.18-1 1.36 0 2.8.75 3.83 2.05-3.37 1.85-2.82 6.65.38 9.29z"/>
                </svg>
                <span class="text-left leading-tight">
                    <span class="block text-[10px] text-white/70">Download on the</span>
                    <span class="block text-sm font-semibold text-white">App Store</span>
                </span>
            </a>
        @endif

        @if ($androidUrl)
            <a
                href="{{ $androidUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-2 rounded-xl border border-white/15 bg-black px-4 py-2 transition hover:bg-black/80"
            >
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M3.6 2.6a1.1 1.1 0 0 0-.6 1v16.8c0 .43.24.82.6 1l10.86-9.4-10.86-9.4z" fill="#00D9FF"/>
                    <path d="M17.3 10.6l-2.9-1.7L11.6 12l2.8 3.1 2.9-1.7c.9-.5.9-2.3 0-2.8z" fill="#FFD900"/>
                    <path d="M3 3l11.6 9L17.3 10.6 5 3.4A1.1 1.1 0 0 0 3 3z" fill="#00F076"/>
                    <path d="M3 21l11.6-9L17.3 13.4 5 20.6a1.1 1.1 0 0 1-2-.6z" fill="#FF3A44"/>
                </svg>
                <span class="text-left leading-tight">
                    <span class="block text-[10px] text-white/70">GET IT ON</span>
                    <span class="block text-sm font-semibold text-white">Google Play</span>
                </span>
            </a>
        @endif
    </div>
@endif
