<x-layout :title="$page->meta_title ?: 'Services — Sadlers Taxis'" :description="$page->meta_description">
    <div class="section">
        <p class="eyebrow">What we offer</p>
        <h1 class="mt-2 text-3xl font-extrabold text-[color:var(--color-ink)] sm:text-4xl">{{ $page->heading }}</h1>

        <div class="mt-6 max-w-3xl">
            <x-rich-text :content="$page->intro_text" />
        </div>

        @if (!empty($page->services))
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($page->services as $service)
                    <div class="rounded-2xl border border-[color:var(--color-border)] bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[color:var(--color-ink)]">{{ $service['title'] ?? '' }}</h3>
                        <p class="mt-2 text-[15px] text-[color:var(--color-muted)]">{{ $service['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
