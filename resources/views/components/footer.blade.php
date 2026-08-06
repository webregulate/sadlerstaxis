<footer class="bg-[color:var(--color-navy)] text-white">
    <div class="mx-auto max-w-6xl px-6 py-14">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($siteSettings->phone_areas ?? [] as $area)
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white/50">
                        {{ $area['areaName'] ?? '' }} Taxis
                    </p>
                    <a
                        href="tel:{{ preg_replace('/\s+/', '', explode('/', $area['phoneNumbers'] ?? '')[0]) }}"
                        class="mt-1 block text-lg font-bold text-white hover:text-[color:var(--color-accent)]"
                    >
                        {{ $area['phoneNumbers'] ?? '' }}
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex flex-col gap-6 border-t border-white/10 pt-8 sm:flex-row sm:items-center sm:justify-between">
            <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-white/70">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('about') }}" class="hover:text-white">About Us</a>
                <a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a>
                <a href="{{ route('privacy-policy') }}" class="hover:text-white">Privacy Policy</a>
                @if ($siteSettings->email)
                    <a href="mailto:{{ $siteSettings->email }}" class="hover:text-white">{{ $siteSettings->email }}</a>
                @endif
            </nav>

            <x-app-badges :ios-url="$siteSettings->ios_app_url" :android-url="$siteSettings->android_app_url" />
        </div>

        <p class="mt-6 text-xs text-white/40">
            Copyright 2010-{{ date('Y') }} © {{ $siteSettings->footer_copyright_name ?: $siteSettings->site_name }}, All Rights Reserved.
        </p>
    </div>
</footer>
