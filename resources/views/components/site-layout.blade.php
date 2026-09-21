@props([
    'title',
    'description',
    'canonical',
    'ogTitle' => null,
    'ogDescription' => null,
    'ogImage' => null,
    'ogImageWidth' => 1200,
    'ogImageHeight' => 630,
    'ogType' => 'website',
    'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
    'navBase' => '',
])

@php
    $domain        = config('clinic.domain');
    $siteUrl       = 'https://' . $domain;
    $cro           = config('clinic.cro');
    $instagram     = config('clinic.instagram');
    $instagramUrl  = 'https://www.instagram.com/' . $instagram . '/';
    $wa            = 'https://wa.me/' . config('clinic.whatsapp');
    $waConsulta    = $wa . '?text=Ol%C3%A1%21%20Gostaria%20de%20agendar%20uma%20consulta%20com%20a%20Dra.%20Emily.';
    $phone         = '+' . config('clinic.whatsapp');
    $ogImageUrl    = $ogImage ?: $siteUrl . '/og-image.jpg';
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ config('clinic.gtm_id') }}');</script>
        <!-- End Google Tag Manager -->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('clinic.ga4_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('clinic.ga4_id') }}');
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @if (config('clinic.google_site_verification'))
            <meta name="google-site-verification" content="{{ config('clinic.google_site_verification') }}">
        @endif

        {{-- ── Primary SEO ───────────────────────────────────────── --}}
        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}">
        <meta name="robots" content="{{ $robots }}">
        <meta name="author" content="Dra. Emily Beatriz">
        <meta name="geo.region" content="BR-MG">
        <meta name="geo.placename" content="Belo Horizonte">
        <link rel="canonical" href="{{ $canonical }}">

        {{-- ── Open Graph ─────────────────────────────────────────── --}}
        <meta property="og:type" content="{{ $ogType }}">
        <meta property="og:url" content="{{ $canonical }}">
        <meta property="og:title" content="{{ $ogTitle ?: $title }}">
        <meta property="og:description" content="{{ $ogDescription ?: $description }}">
        <meta property="og:image" content="{{ $ogImageUrl }}">
        <meta property="og:image:width" content="{{ $ogImageWidth }}">
        <meta property="og:image:height" content="{{ $ogImageHeight }}">
        <meta property="og:locale" content="pt_BR">
        <meta property="og:site_name" content="Dra. Emily Beatriz — Harmonização Facial">

        {{-- ── Twitter / X Card ───────────────────────────────────── --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $ogTitle ?: $title }}">
        <meta name="twitter:description" content="{{ $ogDescription ?: $description }}">
        <meta name="twitter:image" content="{{ $ogImageUrl }}">

        {{-- ── Favicon ─────────────────────────────────────────────── --}}
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>

        @vite(['resources/css/app.css'])

        {{-- ── Schema.org JSON-LD (per-page) ──────────────────────── --}}
        {{ $schema ?? '' }}
    </head>
    <body class="font-sans bg-cream text-charcoal antialiased overflow-x-hidden">

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('clinic.gtm_id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        @include('partials.nav', ['navBase' => $navBase])

        {{ $slot }}

        @include('partials.footer', ['navBase' => $navBase])

    </body>
</html>
