<x-layout :title="$page->meta_title ?: 'Careers — Sadlers Taxis'" :description="$page->meta_description">
    <div class="section">
        <p class="eyebrow">Join our team</p>
        <h1 class="mt-2 text-3xl font-extrabold text-[color:var(--color-ink)] sm:text-4xl">{{ $page->heading }}</h1>

        <div class="mt-8 grid gap-12 lg:grid-cols-2">
            <div>
                <x-rich-text :content="$page->intro_text" />

                <div class="mt-8 rounded-2xl border border-[color:var(--color-border)] bg-[color:var(--color-surface-alt)] p-6">
                    <p class="text-sm font-semibold uppercase tracking-widest text-[color:var(--color-muted)]">
                        Prefer to speak to someone?
                    </p>
                    <p class="mt-2 font-bold text-[color:var(--color-ink)]">{{ $page->contact_name }}</p>
                    <div class="mt-1 flex flex-col gap-1 text-[15px] text-[color:var(--color-muted)]">
                        @if ($page->contact_phone)
                            <a href="tel:{{ preg_replace('/\s+/', '', $page->contact_phone) }}" class="hover:text-[color:var(--color-accent-dark)]">
                                {{ $page->contact_phone }}
                            </a>
                        @endif
                        @if ($page->contact_email)
                            <a href="mailto:{{ $page->contact_email }}" class="hover:text-[color:var(--color-accent-dark)]">
                                {{ $page->contact_email }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if ($page->applicationForm)
                <div class="rounded-2xl border border-[color:var(--color-border)] bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-xl font-bold text-[color:var(--color-ink)]">Apply to drive with us</h2>
                    <div class="mt-6">
                        <x-dynamic-form :form="$page->applicationForm" />
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
