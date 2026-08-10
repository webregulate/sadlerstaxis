<x-layout
    :title="$page->meta_title ?: 'About Us & History — Sadlers Taxis'"
    :description="$page->meta_description"
    :image="$page->history_gallery_urls[0]['url'] ?? null"
>
    <div class="section">
        <p class="eyebrow">About Us</p>
        <h1 class="mt-2 text-3xl font-extrabold text-[color:var(--color-ink)] sm:text-4xl">{{ $page->heading }}</h1>

        <div class="mt-8 grid gap-12 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-rich-text :content="$page->intro_text" />

                @if ($page->history_heading)
                    <h2 class="mt-10 text-2xl font-bold text-[color:var(--color-ink)]">{{ $page->history_heading }}</h2>
                @endif
                <x-rich-text :content="$page->history_text" class="mt-4" />
            </div>

            @if (!empty($page->history_gallery_urls))
                <div class="flex flex-col gap-4 lg:col-span-1">
                    @foreach ($page->history_gallery_urls as $photo)
                        <figure class="overflow-hidden rounded-2xl border border-[color:var(--color-border)] bg-[color:var(--color-surface-alt)]">
                            <img src="{{ $photo['url'] }}" alt="{{ $photo['caption'] ?? '' }}" class="w-full object-cover">
                            @if ($photo['caption'])
                                <figcaption class="px-4 py-2 text-xs text-[color:var(--color-muted)]">
                                    {{ $photo['caption'] }}
                                </figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layout>
