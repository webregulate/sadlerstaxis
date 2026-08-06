<x-layout :title="$page->meta_title ?: 'Contact Us — Sadlers Taxis'" :description="$page->meta_description">
    <div class="section">
        <p class="eyebrow">Get in touch</p>
        <h1 class="mt-2 text-3xl font-extrabold text-[color:var(--color-ink)] sm:text-4xl">{{ $page->heading }}</h1>
        <div class="mt-4 max-w-2xl">
            <x-rich-text :content="$page->intro_text" />
        </div>

        <div class="mt-10 grid gap-12 lg:grid-cols-2">
            @if ($page->contactForm)
                <div class="rounded-2xl border border-[color:var(--color-border)] bg-white p-6 shadow-sm sm:p-8">
                    <x-dynamic-form :form="$page->contactForm" />
                </div>
            @endif

            <div>
                <h2 class="text-xl font-bold text-[color:var(--color-ink)]">Our Office Locations</h2>
                @if ($page->office_address)
                    <p class="mt-2 whitespace-pre-line text-[15px] text-[color:var(--color-muted)]">{{ $page->office_address }}</p>
                @endif

                @if ($page->map_embed_url)
                    <div class="mt-4 overflow-hidden rounded-2xl border border-[color:var(--color-border)]">
                        <iframe
                            src="{{ $page->map_embed_url }}"
                            width="100%"
                            height="320"
                            style="border:0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Sadlers Taxis office locations"
                        ></iframe>
                    </div>
                @endif

                <div class="mt-8 grid grid-cols-2 gap-4">
                    @foreach ($settings->phone_areas ?? [] as $area)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-[color:var(--color-muted)]">
                                {{ $area['areaName'] ?? '' }}
                            </p>
                            <a
                                href="tel:{{ preg_replace('/\s+/', '', explode('/', $area['phoneNumbers'] ?? '')[0]) }}"
                                class="mt-0.5 block font-bold text-[color:var(--color-ink)] hover:text-[color:var(--color-accent-dark)]"
                            >
                                {{ $area['phoneNumbers'] ?? '' }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>
