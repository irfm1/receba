<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
<meta name="theme-color" content="#4f46e5" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="apple-mobile-web-app-title" content="Receba" />
<meta name="mobile-web-app-capable" content="yes" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<!-- PWA -->
<link rel="manifest" href="/manifest.json" />
<meta name="msapplication-TileColor" content="#4f46e5" />
<meta name="msapplication-config" content="/browserconfig.xml" />

<!-- Service Worker -->
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js');
    }
</script>
