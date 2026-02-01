<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blogify')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #121212;
            --bg-secondary: #1a1a1a;
            --bg-tertiary: #1f1f1f;
            --border-color: #2a2a2a;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --text-muted: #6b7280;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

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
        }

        .btn-signin {
            background: transparent;
            border: 1px solid #333;
            color: var(--text-primary);
        }

        .btn-signin:hover {
            background: var(--bg-tertiary);
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
        }

        .layout {
            display: flex;
            height: calc(100vh - 70px);
        }

        .sidebar {
            width: 250px;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: 10px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--accent-color);
            color: white;
        }

        .main {
            flex: 1;
            overflow-y: auto;
            background: var(--bg-primary);
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        .sidebar-close {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: white;
            align-self: flex-end;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                height: calc(100% - 70px);
                background: var(--bg-secondary);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 999;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-close {
                display: block;
                margin-bottom: 1rem;
            }

            .layout {
                flex-direction: column;
            }

            .main {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">Blogify</div>
                        <div class="flex items-center gap-3 mb-6">
                    <div>
                        <p class="font-semibold text-white text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">welcome back!</p>
                    </div>
                </div>
        @auth
            <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        @endauth
    </header>

    <div class="layout">
        @auth
            <aside class="sidebar" id="sidebar">


                <button class="sidebar-close" onclick="toggleSidebar()">
                    <i class="fas fa-times"></i>
                </button>
                <a href="{{ route('home.page') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('notifications.page') }}"
                    class="{{ request()->is('user/account/notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> Notifications
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <span
                            style="background: red; color: white; font-size: 0.75rem; padding: 2px 6px; border-radius: 10px; margin-left: auto;">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('dashboard.page') }}" class="{{ request()->is('user/account/posts') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> My Posts
                </a>
                <a href="{{ route('post.add.page') }}"
                    class="{{ request()->is('user/account/create/post') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Create Post
                </a>
                <a href="{{ route('profile.page') }}" class="{{ request()->is('user/account/profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Profile
                </a>
            </aside>
        @endauth

        <main class="main">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>

    @stack('scripts')
</body>

</html>
