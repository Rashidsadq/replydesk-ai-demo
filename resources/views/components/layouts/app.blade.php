<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}" dir="{{ session('locale') === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-slate-50 text-slate-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ReplyDesk AI — B2B SaaS Receptionist for WhatsApp' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: {{ session('locale') === 'ar' ? "'Noto Sans Arabic', 'Instrument Sans', sans-serif" : "'Instrument Sans', system-ui, sans-serif" }};
        }
    </style>
</head>
<body class="h-full font-sans antialiased overflow-x-hidden selection:bg-purple-500 selection:text-white">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-50 flex flex-col md:flex-row">
        
        <!-- Sidebar Navigation Component -->
        <x-sidebar />

        <!-- Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header Component -->
            <x-topbar />

            <!-- Page Content View -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
