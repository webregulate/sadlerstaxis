@php
    $ogImage = $image ?? null;
    $pageTitle = $title ?? 'Sadlers Taxis';
    $pageDescription = $description ?? 'Family-run taxi and private hire company covering the Epping Forest District since 1869.';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sadlers Taxis">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @else
        <meta name="twitter:card" content="summary">
    @endif
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">

    <x-structured-data />

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
