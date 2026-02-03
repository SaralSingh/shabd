<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications — Shabd</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root {
            /* SHABD Design System */
            --ink-primary: #1c1c1e;       
            --ink-secondary: #52525b;     
            --paper-bg: #f5f5f0;          
            --card-bg: #ffffff;
            --accent-color: #bc4749;      
            --border-line: #e4e4e7;
            --radius-sharp: 4px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--paper-bg);
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            color: var(--ink-primary);
            min-height: 100vh;
        }

       /* --- Unified Navbar --- */
        .navbar {
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: rgba(245, 245, 240, 0.95);
            backdrop-filter: blur(8px);
            position: sticky; 
            top: 0; 
            z-index: 100;
            flex-wrap: nowrap; /* Default no wrap */
            gap: 2rem;
            transition: all 0.3s ease;
        }

        /* Logo Section */
        .nav-left {
            display: flex; 
            align-items: center; 
            gap: 15px; 
            flex-shrink: 0; /* Don't shrink logo */
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--ink-primary);
        }

        /* Search Section (Centered) */
        .nav-search {
            flex-grow: 1;
            max-width: 500px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.7rem 1rem 0.7rem 2.8rem;
            border: 1px solid var(--border-line);
            border-radius: 50px;
            background: var(--card-bg);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--ink-primary);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--ink-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .search-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-secondary);
            font-size: 0.9rem;
            pointer-events: none;
        }

        /* Actions Section */
        .nav-actions {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .nav-actions a {
            text-decoration: none;
            color: var(--ink-primary);
            font-size: 0.9rem;
            font-weight: 500;
            margin-left: 1.5rem;
            transition: color 0.2s;
        }
        .nav-actions a:hover { color: var(--accent-color); }

        .active-link {
            color: var(--ink-primary) !important;
            font-weight: 700 !important;
            border-bottom: 2px solid var(--accent-color);
        }

        .nav-badge {
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 12px;
            margin-left: 6px;
            display: inline-block;
        }

        /* Menu Button (Mobile) */
        .menu-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--ink-primary);
            cursor: pointer;
            padding: 5px;
            display: none; /* Hidden on desktop */
        }

        /* --- Sidebar & Overlay --- */
        .sidebar {
            position: fixed; top: 0; left: -300px; width: 300px; height: 100vh;
            background: var(--paper-bg); border-right: 1px solid var(--border-line);
            padding: 2rem; z-index: 1000; transition: left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex; flex-direction: column; gap: 1.5rem;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
        }
        .sidebar.open { left: 0; }
        .sidebar a { text-decoration: none; color: var(--ink-secondary); font-size: 1rem; font-weight: 500; display: flex; align-items: center; gap:10px; }
        .sidebar a:hover { color: var(--ink-primary); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); z-index: 999; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
        .overlay.show { opacity: 1; pointer-events: auto; }

        /* --- Feed Layout --- */
        .feed-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            min-height: 60vh;
        }

        /* Article Card */
        .article-card {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            margin-bottom: 2.5rem;
            display: grid;
            grid-template-columns: 200px 1fr;
            border-radius: var(--radius-sharp);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .article-card:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-color: var(--ink-primary); }
        
        .article-image-wrapper { width: 100%; height: 100%; overflow: hidden; background: #eee; }
        .article-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .article-card:hover .article-image { transform: scale(1.05); }
        
        .article-content { padding: 2rem; display: flex; flex-direction: column; justify-content: space-between; }
        .article-meta { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink-secondary); margin-bottom: 0.8rem; }
        .article-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--ink-primary); margin-bottom: 0.8rem; line-height: 1.3; }
        .article-excerpt { font-family: 'DM Sans', sans-serif; font-size: 0.95rem; color: var(--ink-secondary); line-height: 1.6; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .article-footer { border-top: 1px solid var(--border-line); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: var(--ink-secondary); }

        /* --- Responsive Design --- */
        @media (max-width: 900px) {
            .navbar {
        
                flex-wrap: wrap; /* Allow search to wrap */
                padding: 1rem;
                gap: 3rem;
            }
            
            .nav-left {
                flex-grow: 1; /* Logo takes left space */
            }

            .nav-actions {
                display: none; /* Hide standard links on mobile */
            }

            .menu-btn {
                display: block; /* Show hamburger */
            }

            /* Search bar takes full width on a new line */
            .nav-search {
                order: 3; 
                width: 100%;
                max-width: none;
                margin: 0;
            }

            .article-card {
                grid-template-columns: 1fr;
                grid-template-rows: 250px auto;
            }
            
            .feed-container { padding: 1.5rem 1rem; }
        }
        /* --- Notifications Layout --- */
        .notif-container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        .notif-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-line);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notif-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ink-primary);
        }

        /* Notification List */
        .notif-list {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            overflow: hidden;
        }

        .notif-item {
            padding: 1.2rem;
            border-bottom: 1px solid var(--border-line);
            display: flex;
            gap: 15px;
            align-items: flex-start;
            transition: background 0.2s;
        }

        .notif-item:last-child { border-bottom: none; }
        .notif-item:hover { background: #fafafa; }

        .notif-icon {
            color: var(--accent-color);
            margin-top: 3px;
            font-size: 1rem;
        }

        .notif-content { flex: 1; }

        .notif-link {
            text-decoration: none;
            color: var(--ink-primary);
            font-size: 1rem;
            line-height: 1.5;
            display: block;
        }
        .notif-link:hover { text-decoration: underline; color: var(--accent-color); }

        .notif-time {
            font-size: 0.8rem;
            color: var(--ink-secondary);
            margin-top: 5px;
            display: block;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--ink-secondary);
        }
        .empty-state i {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        @media (max-width: 600px) {
            .notif-item { padding: 1rem; }
        }
    </style>
</head>

<body>
    @php $user = Auth::user(); @endphp

   <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    @auth
    <aside class="sidebar" id="sidebar">
        <button onclick="toggleSidebar()" style="background:none; border:none; align-self:flex-end; font-size:1.2rem; cursor:pointer; color:var(--ink-secondary);">&times;</button>
        <div style="font-family:'Playfair Display'; font-weight:700; font-size:1.5rem; margin-bottom:1rem; color:var(--ink-primary);">Shabd.</div>
        
        <a href="{{ route('home.page') }}" class="{{ request()->is('posts') ? 'active-link' : '' }}">
            <i class="fas fa-home"></i> Discover
        </a>
        
        <a href="{{ route('notifications.page') }}" class="{{ request()->is('user/account/notifications') ? 'active-link' : '' }}">
            <i class="fas fa-bell"></i> Notifications 
            @if(Auth::user()->unreadNotifications->count() > 0) 
                <span class="nav-badge" style="margin-left:auto;">{{ Auth::user()->unreadNotifications->count() }}</span> 
            @endif
        </a>
        
        <a href="{{ route('post.add.page') }}" class="{{ request()->is('user/account/create/post') ? 'active-link' : '' }}"><i class="fas fa-plus-circle"></i> Create Post</a>
        <a href="{{ route('dashboard.page') }}" class="{{ request()->is('user/account/posts') ? 'active-link' : '' }}"><i class="fas fa-file-alt"></i> My Posts</a>
        <a href="{{ route('profile.page') }}" class="{{ request()->is('user/account/profile') ? 'active-link' : '' }}"><i class="fas fa-user"></i> Profile</a>
        
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:var(--accent-color);">
            <i class="fas fa-sign-out-alt"></i> Sign Out
        </a>
    </aside>
    @endauth

    <nav class="navbar">
        <div class="nav-left">
            @auth
                <button class="menu-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            @endauth
            <a href="{{ route('main.page') }}" class="logo">Shabd.</a>
        </div>

        <div class="nav-actions">
            <a href="{{ route('home.page') }}" class="{{ request()->is('posts') ? 'active-link' : '' }}">Discover</a>

            @auth
                <a href="{{ route('notifications.page') }}" class="{{ request()->is('user/account/notifications') ? 'active-link' : '' }}" style="display:inline-flex; align-items:center;">
                    Notifications
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <span class="nav-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

                <a href="{{ route('post.add.page') }}">Write</a>
                <a href="{{ route('dashboard.page') }}">My Posts</a>
                
                <a href="{{ route('profile.page') }}" style="font-weight:700;">{{ Auth::user()->username }}</a>
                
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:var(--accent-color);">Sign Out</a>
            @else
                <a href="{{ route('login.page') }}">Sign In</a>
                <a href="{{ route('register.page') }}" style="font-weight:700;">Join</a>
            @endguest
        </div>
    </nav>

    <main class="notif-container">
        
        <div class="notif-header">
            <h1 class="notif-title">Activity</h1>
        </div>

        <div class="notif-list">
            @forelse ($notifications as $notification)
                <div class="notif-item">
                    <div class="notif-icon">
                        <i class="fas fa-circle" style="font-size: 8px;"></i>
                    </div>
                    <div class="notif-content">
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-link">
                            {{ $notification->data['message'] ?? 'New notification' }}
                        </a>
                        <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="far fa-bell-slash"></i>
                    <p>You are all caught up.</p>
                </div>
            @endforelse
        </div>

    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">@csrf</form>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }
    </script>
</body>
</html>