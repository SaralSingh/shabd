<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Blogify')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        :root {
            --bg-primary: #121212;
            --bg-secondary: #1a1a1a;
            --border-color: #2a2a2a;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        /* Header */
        header {
            background: var(--bg-secondary);
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .nav-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.5rem 1.1rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.9rem;
            transition: 0.2s;
            border: none;
            color: var(--text-primary);
            background: transparent;
            border: 1px solid #333;
        }

        .btn:hover {
            background: var(--bg-primary);
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
        }

        main {
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        @media (max-width: 600px) {
            .nav-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Blogify</div>
        <nav class="nav-actions">
            <a href="{{ route('login.page') }}" class="btn">Login</a>
            <a href="{{ route('register.page') }}" class="btn btn-primary">Register</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
