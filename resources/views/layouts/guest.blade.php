<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Shabd - Join a premium community for sharing wisdom and stories.')">
    <meta name="keywords" content="@yield('meta_keywords', 'register, login, community, Shabd, Saral Singh, wisdom')">
    <meta name="author" content="Saral Singh">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="official-site" content="https://saralsingh.space/">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Shabd') - Join the Movement">
    <meta property="og:description" content="@yield('meta_description', 'Shabd is where creators connect. Sign up today and experience wisdom through words by Saral Singh.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:site_name" content="Shabd">

    <title>@yield('title', 'Shabd') | Saral Singh Official</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Unified Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body class="guest-layout">

    <!-- Flash Messages -->
    @if (session('error'))
        <div id="flash-toast" class="custom-toast" style="display: block; background: #e11d48; color: white;">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

    <!-- Unified Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
