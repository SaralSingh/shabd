<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Shabd - A premium platform for sharing thoughts and stories.')">
    <meta name="keywords" content="@yield('meta_keywords', 'writing, blogging, stories, sharing, platform, Shabd, Saral Singh')">
    <meta name="author" content="Saral Singh">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="official-site" content="https://saralsingh.space/">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Shabd') - Share Your Voice">
    <meta property="og:description" content="@yield('meta_description', 'Shabd is a modern platform where voices meet wisdom. Join Saral Singh and other creators today.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:site_name" content="Shabd">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Shabd') - Share Your Voice">
    <meta property="twitter:description" content="@yield('meta_description', 'Shabd is a modern platform where voices meet wisdom. Join Saral Singh and other creators today.')">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="twitter:creator" content="@SaralSingh">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Shabd",
      "url": "https://appsaral.alwaysdata.net/",
      "author": {
        "@type": "Person",
        "name": "Saral Singh",
        "url": "https://saralsingh.space/"
      },
      "description": "Shabd is a premium content-sharing platform designed for writers and readers, emphasizing clarity and minimalist design.",
      "publisher": {
        "@type": "Organization",
        "name": "Saral Singh",
        "url": "https://saralsingh.space/"
      }
    }
    </script>

    <title>@yield('title', 'Shabd') | Saral Singh Official</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Unified Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    @auth
        <!-- Overlay for mobile sidebar -->
        <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
        @include('components.sidebar')
    @endauth

    @include('components.header')

    <!-- Flash Messages -->
    @if (session('success'))
        <div id="flash-toast" class="custom-toast" style="display: block;">
            {{ session('success') }}
        </div>
    @endif

    <div class="scrollable-content">
        <main class="main-content">
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <!-- Unified Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
