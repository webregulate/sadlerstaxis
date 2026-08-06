<x-layout :title="$page->meta_title ?: 'Business & Personal Accounts — Sadlers Taxis'" :description="$page->meta_description">
    <div class="section">
        <p class="eyebrow">Accounts</p>
        <h1 class="mt-2 text-3xl font-extrabold text-[color:var(--color-ink)] sm:text-4xl">{{ $page->heading }}</h1>

        <div class="mt-6 max-w-3xl">
            <x-rich-text :content="$page->intro_text" />
        </div>

        @if (!empty($page->benefits))
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($page->benefits as $benefit)
                    <div class="rounded-2xl border border-[color:var(--color-border)] bg-[color:var(--color-surface-alt)] p-6">
                        <h3 class="text-lg font-bold text-[color:var(--color-ink)]">{{ $benefit['title'] ?? '' }}</h3>
                        <p class="mt-2 text-[15px] text-[color:var(--color-muted)]">{{ $benefit['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($page->newAccountForm)
            <div class="mt-14 rounded-2xl border border-[color:var(--color-border)] bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-xl font-bold text-[color:var(--color-ink)]">{{ $page->newAccountForm->name }}</h2>
                <div class="mt-6 max-w-2xl">
                    <x-dynamic-form :form="$page->newAccountForm" />
                </div>

                @if ($page->terms_text)
                    <div class="mt-8 border-t border-[color:var(--color-border)] pt-6">
                        <x-rich-text :content="$page->terms_text" class="text-sm" />
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-layout>
