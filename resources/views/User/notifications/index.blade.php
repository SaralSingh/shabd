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

        /* --- Navbar & Sidebar (Standard) --- */
        .navbar {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: var(--paper-bg);
            position: relative; z-index: 50;
        }
        .nav-left { display: flex; align-items: center; gap: 15px; }
        .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; text-decoration: none; color: var(--ink-primary); }
        .menu-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-primary); }
        
        .sidebar {
            position: fixed; top: 0; left: -300px; width: 300px; height: 100vh;
            background: var(--paper-bg); border-right: 1px solid var(--border-line);
            padding: 2rem; z-index: 1000; transition: left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex; flex-direction: column; gap: 1rem;
        }
        .sidebar.open { left: 0; }
        .sidebar a { text-decoration: none; color: var(--ink-secondary); padding: 10px; display: flex; align-items: center; gap: 10px; }
        .sidebar a:hover { color: var(--ink-primary); background: rgba(0,0,0,0.03); }
        .sidebar a.active { color: var(--ink-primary); font-weight: 700; border-left: 3px solid var(--accent-color); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); z-index: 999; display: none; }
        .overlay.show { display: block; }
        .nav-badge { background: var(--accent-color); color: white; font-size: 0.7rem; padding: 1px 6px; border-radius: 10px; margin-left: auto; }

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
    <aside class="sidebar" id="sidebar">
        <button onclick="toggleSidebar()" style="background:none; border:none; align-self:flex-end; font-size:1.2rem; cursor:pointer;">&times;</button>
        <div style="font-family:'Playfair Display'; font-weight:700; font-size:1.5rem; margin-bottom:1rem;">Shabd.</div>
        <a href="{{ route('home.page') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('notifications.page') }}" class="active"><i class="fas fa-bell"></i> Notifications @if($user->unreadNotifications->count() > 0) <span class="nav-badge">{{ $user->unreadNotifications->count() }}</span> @endif</a>
        <a href="{{ route('dashboard.page') }}"><i class="fas fa-file-alt"></i> My Posts</a>
        <a href="{{ route('post.add.page') }}"><i class="fas fa-plus-circle"></i> Create Post</a>
        <a href="{{ route('profile.page') }}"><i class="fas fa-user"></i> Profile</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-top:auto; color:var(--accent-color);">Sign Out</a>
    </aside>

    <nav class="navbar">
        <div class="nav-left">
            <button class="menu-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <a href="{{ route('main.page') }}" class="logo">Shabd.</a>
        </div>
        <div class="nav-actions">
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