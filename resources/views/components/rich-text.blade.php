@props(['content', 'class' => ''])

@if ($content)
    <div {{ $attributes->merge(['class' => 'rich-text '.$class]) }}>
        {!! $content !!}
    </div>
@endif
