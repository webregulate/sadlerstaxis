<x-layout title="Privacy Policy — Sadlers Taxis">
    <div class="section max-w-3xl">
        <h1 class="text-3xl font-extrabold text-[color:var(--color-ink)] sm:text-4xl">{{ $page->heading }}</h1>
        @if ($page->last_updated)
            <p class="mt-2 text-sm text-[color:var(--color-muted)]">
                Last updated: {{ $page->last_updated->format('j F Y') }}
            </p>
        @endif
        <x-rich-text :content="$page->content" class="mt-8" />
    </div>
</x-layout>
