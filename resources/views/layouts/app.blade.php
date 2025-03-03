<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Stembayo Event - Platform Event SMK N 2 Depok Sleman')">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Welcome')</title>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|montserrat:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles & Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/css/dashboard.css',
        'resources/css/empty-state.css',
        'resources/css/show.css',
        'resources/css/eventonly.css',
        'resources/css/profile.css',
        'resources/css/sidebar.css',
        'resources/css/create.css',
        'resources/js/app.js'
    ])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#f8f9fa]">
    @include('layouts.navbar')
    
    <div class="flex min-h-screen">
        @include('layouts.sidebar')
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    @include('layouts.footer')
    @stack('scripts')
</body>
</html>
