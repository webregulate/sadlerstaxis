<x-layout
    :title="$page->meta_title ?: 'Sadlers Taxis — Taxis in Loughton, Chigwell & the Epping Forest District'"
    :description="$page->meta_description ?: 'Family-run taxi and private hire company covering the Epping Forest District since 1869.'"
>
    <section class="relative overflow-hidden bg-[color:var(--color-navy)] text-white">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 py-20 sm:py-28 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="eyebrow text-[color:var(--color-accent)]">{{ $settings->tagline }}</p>
                <h1 class="mt-3 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    {{ $page->hero_heading }}
                </h1>
                <p class="mt-5 max-w-xl text-lg text-white/70">{{ $page->hero_subheading }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($settings->book_online_url)
                        <a href="{{ $settings->book_online_url }}" target="_blank" rel="noopener noreferrer" class="btn-accent">
                            Book Online
                        </a>
                    @endif
                    @if ($settings->primary_phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->primary_phone) }}" class="btn-outline">
                            Call {{ $settings->primary_phone }}
                        </a>
                    @endif
                </div>
            </div>

            @if ($page->hero_image_url)
                <div class="relative aspect-[4/3] overflow-hidden rounded-2xl">
                    <img src="{{ $page->hero_image_url }}" alt="" class="h-full w-full object-cover">
                </div>
            @else
                <div class="rounded-2xl border border-white/10 bg-white/5 p-8">
                    <p class="text-sm font-semibold uppercase tracking-widest text-white/40">Covering</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($settings->phone_areas ?? [] as $area)
                            <span class="rounded-full border border-white/15 px-3 py-1 text-sm text-white/80">
                                {{ $area['areaName'] ?? '' }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="section">
        <x-rich-text :content="$page->intro_text" />
    </section>

    @if (!empty($page->highlights))
        <section class="bg-[color:var(--color-surface-alt)]">
            <div class="section">
                <h2 class="text-2xl font-bold text-[color:var(--color-ink)] sm:text-3xl">Why choose Sadlers Taxis</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($page->highlights as $item)
                        <div class="rounded-2xl border border-[color:var(--color-border)] bg-white p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-[color:var(--color-ink)]">{{ $item['title'] ?? '' }}</h3>
                            <p class="mt-2 text-[15px] text-[color:var(--color-muted)]">{{ $item['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($settings->ios_app_url || $settings->android_app_url)
        <section class="bg-[color:var(--color-navy)]">
            <div class="section flex flex-col items-center gap-8 text-center lg:flex-row lg:text-left">
                <div class="flex-1">
                    <p class="eyebrow text-[color:var(--color-accent)]">Book on the go</p>
                    <h2 class="mt-2 text-2xl font-bold text-white sm:text-3xl">Get the Sadlers Taxis app</h2>
                    <p class="mx-auto mt-3 max-w-xl text-white/70 lg:mx-0">
                        Book faster from your phone — download the app for iPhone or Android.
                    </p>
                    <div class="mt-6 flex justify-center lg:justify-start">
                        <x-app-badges :ios-url="$settings->ios_app_url" :android-url="$settings->android_app_url" />
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="rounded-2xl bg-[color:var(--color-ink)] px-8 py-12 text-center text-white sm:px-16">
            <h2 class="text-2xl font-bold sm:text-3xl">Need a taxi right now?</h2>
            <p class="mx-auto mt-3 max-w-xl text-white/70">
                Call your nearest office directly, or book online in a couple of taps.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                @if ($settings->book_online_url)
                    <a href="{{ $settings->book_online_url }}" target="_blank" rel="noopener noreferrer" class="btn-accent">
                        Book Online
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="btn-outline">Contact Us</a>
            </div>
        </div>
    </section>
</x-layout>
