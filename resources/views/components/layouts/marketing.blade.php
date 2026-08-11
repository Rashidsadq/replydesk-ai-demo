<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}" dir="{{ session('locale') === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-slate-900 text-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReplyDesk AI — Your AI Receptionist for WhatsApp | Dubai Salons & Barbers</title>
    <meta name="description" content="ReplyDesk AI automatically answers customers, captures leads, and books salon appointments 24/7 on WhatsApp for Dubai businesses.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @if(file_exists(public_path('build/manifest.json')))
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        @if(isset($manifest['resources/css/app.css']['file']))
            <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
        @endif
        @if(isset($manifest['_fonts-C9MNnjVw.css']['file']))
            <link rel="stylesheet" href="{{ asset('build/' . $manifest['_fonts-C9MNnjVw.css']['file']) }}">
        @endif
        @if(isset($manifest['resources/js/app.js']['file']))
            <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
        @endif
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @livewireStyles

    <style>
        body {
            font-family: {{ session('locale') === 'ar' ? "'Noto Sans Arabic', 'Instrument Sans', sans-serif" : "'Instrument Sans', system-ui, sans-serif" }};
        }
    </style>
</head>
<body class="h-full bg-slate-950 font-sans antialiased selection:bg-purple-500 selection:text-white">
    {{ $slot }}
    @livewireScripts
</body>
</html>
