@php
    $settings = \App\Models\SiteSetting::current();

    $areaServed = collect($settings->phone_areas ?? [])
        ->pluck('areaName')
        ->filter()
        ->map(fn ($name) => ['@type' => 'Place', 'name' => $name])
        ->values()
        ->all();

    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'TaxiService',
        'name' => $settings->site_name,
        'url' => url('/'),
        'telephone' => $settings->primary_phone,
        'email' => $settings->email,
        'image' => $settings->logo_url,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Loughton Station',
            'addressLocality' => 'Loughton',
            'addressRegion' => 'Essex',
            'addressCountry' => 'GB',
        ],
        'areaServed' => $areaServed,
        'sameAs' => array_values(array_filter([
            $settings->ios_app_url,
            $settings->android_app_url,
        ])),
    ]);
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES) !!}</script>
