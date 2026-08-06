@php
    $navLinks = [
        'home' => 'Home',
        'about' => 'About Us',
        'services' => 'Services',
        'accounts' => 'Accounts',
        'careers' => 'Careers',
        'contact' => 'Contact',
    ];
@endphp

@if ($siteSettings->show_warning_banner && $siteSettings->warning_banner)
    <div class="bg-[color:var(--color-accent)] px-4 py-2 text-center text-sm font-medium text-[color:var(--color-ink)]">
        {{ $siteSettings->warning_banner }}
    </div>
@endif

<header class="sticky top-0 z-50 bg-[color:var(--color-navy)]">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="flex flex-col leading-tight">
            <span class="font-logo text-2xl tracking-wide text-[color:var(--color-logo)]">
                {{ $siteSettings->site_name }}
            </span>
            @if ($siteSettings->tagline)
                <span class="text-xs font-medium text-white/70">{{ $siteSettings->tagline }}</span>
            @endif
        </a>

        <nav class="hidden items-center gap-8 lg:flex">
            @foreach ($navLinks as $routeName => $label)
                <a
                    href="{{ route($routeName) }}"
                    class="text-sm font-semibold text-white/85 transition hover:text-[color:var(--color-accent)] {{ request()->routeIs($routeName) ? 'text-[color:var(--color-accent)]' : '' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            @if ($siteSettings->primary_phone)
                <a href="tel:{{ preg_replace('/\s+/', '', $siteSettings->primary_phone) }}" class="btn-outline">
                    {{ $siteSettings->primary_phone }}
                </a>
            @endif
            @if ($siteSettings->book_online_url)
                <a href="{{ $siteSettings->book_online_url }}" target="_blank" rel="noopener noreferrer" class="btn-accent">
                    Book Now
                </a>
            @endif
        </div>

        <details class="relative lg:hidden">
            <summary class="flex h-10 w-10 list-none items-center justify-center rounded-lg border border-white/20 text-white">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                <span class="sr-only">Menu</span>
            </summary>
            <div class="absolute right-0 top-12 w-64 rounded-2xl border border-[color:var(--color-border)] bg-white p-4 shadow-lg">
                <nav class="flex flex-col gap-3">
                    @foreach ($navLinks as $routeName => $label)
                        <a href="{{ route($routeName) }}" class="text-sm font-semibold text-[color:var(--color-ink)]">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
                <div class="mt-4 flex flex-col gap-2">
                    @if ($siteSettings->primary_phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $siteSettings->primary_phone) }}" class="btn-outline-dark w-full">
                            Call {{ $siteSettings->primary_phone }}
                        </a>
                    @endif
                    @if ($siteSettings->book_online_url)
                        <a href="{{ $siteSettings->book_online_url }}" target="_blank" rel="noopener noreferrer" class="btn-accent w-full">
                            Book Now
                        </a>
                    @endif
                </div>
            </div>
        </details>
    </div>
</header>
