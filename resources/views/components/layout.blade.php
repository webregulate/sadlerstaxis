<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Sadlers Taxis' }}</title>
    @if (!empty($description))
        <meta name="description" content="{{ $description }}">
    @endif
    @vite(['resources/css/app.css'])
</head>
<body>
    <x-header />

    <main>
        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>
