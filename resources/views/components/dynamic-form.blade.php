@props(['form'])

@if (session('form_submitted') == $form->id)
    <div class="rounded-2xl border border-[color:var(--color-accent)]/40 bg-[color:var(--color-accent)]/10 p-6 text-[color:var(--color-ink)]">
        <p class="font-semibold">{{ session('form_confirmation_message') }}</p>
    </div>
@else
    <form method="POST" action="{{ route('forms.submit', $form) }}" class="space-y-5">
        @csrf

        {{-- Honeypot: invisible to real visitors, bots that blindly fill every field trip it --}}
        <div style="position:absolute; left:-9999px;" aria-hidden="true">
            <label for="hp_website">Leave this field blank</label>
            <input type="text" name="hp_website" id="hp_website" tabindex="-1" autocomplete="off">
        </div>

        @error('turnstile')
            <p class="text-sm font-medium text-red-600">{{ $message }}</p>
        @enderror

        @foreach ($form->fields as $field)
            @php
                $type = $field['type'] ?? 'text';
                $name = $field['name'] ?? null;
                $required = $field['required'] ?? false;
                $label = $field['label'] ?? '';
            @endphp

            @if ($type === 'heading')
                <h3 class="pt-2 text-lg font-bold text-[color:var(--color-ink)] first:pt-0">{{ $label }}</h3>
            @elseif ($name)
                @if ($type === 'checkbox')
                    <label class="flex items-center gap-2 text-sm text-[color:var(--color-ink)]">
                        <input
                            type="checkbox"
                            name="{{ $name }}"
                            value="1"
                            {{ old($name) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-[color:var(--color-border)]"
                        >
                        {{ $label }}
                        @if ($required)<span class="text-[color:var(--color-accent-dark)]"> *</span>@endif
                    </label>
                @elseif ($type === 'select')
                    <div>
                        <label class="form-label" for="{{ $name }}">
                            {{ $label }}
                            @if ($required)<span class="text-[color:var(--color-accent-dark)]"> *</span>@endif
                        </label>
                        <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif class="form-input">
                            <option value="" disabled {{ old($name) ? '' : 'selected' }}>Please select</option>
                            @foreach ($field['options'] ?? [] as $option)
                                <option value="{{ $option['value'] }}" {{ old($name) === $option['value'] ? 'selected' : '' }}>
                                    {{ $option['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($type === 'textarea')
                    <div>
                        <label class="form-label" for="{{ $name }}">
                            {{ $label }}
                            @if ($required)<span class="text-[color:var(--color-accent-dark)]"> *</span>@endif
                        </label>
                        <textarea id="{{ $name }}" name="{{ $name }}" rows="4" @if ($required) required @endif class="form-input">{{ old($name) }}</textarea>
                    </div>
                @else
                    <div>
                        <label class="form-label" for="{{ $name }}">
                            {{ $label }}
                            @if ($required)<span class="text-[color:var(--color-accent-dark)]"> *</span>@endif
                        </label>
                        <input
                            id="{{ $name }}"
                            type="{{ $type === 'email' ? 'email' : 'text' }}"
                            name="{{ $name }}"
                            value="{{ old($name) }}"
                            @if ($required) required @endif
                            class="form-input"
                        >
                    </div>
                @endif

                @error($name)
                    <p class="text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            @endif
        @endforeach

        @if (\App\Support\Turnstile::isEnabled())
            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
        @endif

        <button type="submit" class="btn-accent w-full sm:w-auto">
            {{ $form->submit_button_label ?: 'Submit' }}
        </button>
    </form>

    @if (\App\Support\Turnstile::isEnabled())
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
@endif
