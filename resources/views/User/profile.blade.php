<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — Shabd</title>
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

        /* --- Navbar & Sidebar (Shared) --- */
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
        .nav-actions a { text-decoration: none; color: var(--ink-primary); font-size: 0.9rem; font-weight: 500; margin-left: 1.5rem; }
        .menu-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-primary); }
        
        /* Sidebar */
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

        /* --- Profile Card Layout --- */
        .profile-container {
            max-width: 600px;
            margin: 4rem auto;
            padding: 0 20px;
        }

        .profile-card {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            padding: 3rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            position: relative;
        }

        /* Avatar */
        .profile-avatar-wrapper {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem auto;
            border-radius: 50%;
            padding: 4px;
            border: 1px solid var(--border-line);
            position: relative;
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Text Info */
        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink-primary);
            margin-bottom: 0.5rem;
        }

        .profile-handle {
            font-size: 1rem;
            color: var(--accent-color);
            font-weight: 500;
            margin-bottom: 2rem;
            display: block;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2.5rem;
            border-top: 1px solid var(--border-line);
            border-bottom: 1px solid var(--border-line);
            padding: 1.5rem 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ink-primary);
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--ink-secondary);
        }

        /* Details List */
        .details-list {
            text-align: left;
            margin-bottom: 2.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-size: 0.95rem;
        }

        .detail-label { color: var(--ink-secondary); font-weight: 500; }
        .detail-value { color: var(--ink-primary); }

        /* Logout Button Area */
        .logout-btn {
            width: 100%;
            padding: 1rem;
            background: transparent;
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border-radius: var(--radius-sharp);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logout-btn:hover {
            background: var(--accent-color);
            color: white;
        }

        @media (max-width: 600px) {
            .profile-card { padding: 2rem 1.5rem; }
        }
    </style>
</head>

<body>
    @php
        $user = Auth::user();
    @endphp

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <button onclick="toggleSidebar()" style="background:none; border:none; align-self:flex-end; font-size:1.2rem; cursor:pointer;">&times;</button>
        <div style="font-family:'Playfair Display'; font-weight:700; font-size:1.5rem; margin-bottom:1rem;">Shabd.</div>
        <a href="{{ route('home.page') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('notifications.page') }}"><i class="fas fa-bell"></i> Notifications @if($user->unreadNotifications->count() > 0) <span class="nav-badge">{{ $user->unreadNotifications->count() }}</span> @endif</a>
        <a href="{{ route('dashboard.page') }}"><i class="fas fa-file-alt"></i> My Posts</a>
        <a href="{{ route('post.add.page') }}"><i class="fas fa-plus-circle"></i> Create Post</a>
        <a href="{{ route('profile.page') }}" class="active"><i class="fas fa-user"></i> Profile</a>
        
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-top:auto; color:var(--accent-color);">
            <i class="fas fa-sign-out-alt"></i> Sign Out
        </a>
    </aside>

    <nav class="navbar">
        <div class="nav-left">
            <button class="menu-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <a href="{{ route('main.page') }}" class="logo">Shabd.</a>
        </div>
        <div class="nav-actions">
            <a href="{{ route('home.page') }}">Discover</a>
            <a href="{{ route('post.add.page') }}">Write</a>
            <a href="{{ route('dashboard.page') }}">Dashboard</a>
        </div>
    </nav>

    <main class="profile-container">
        
        <div class="profile-card">
            
            <div class="profile-avatar-wrapper">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=random' }}" 
                     alt="Profile Picture" class="profile-avatar">
            </div>

            <h1 class="profile-name">{{ $user->name }}</h1>
            <span class="profile-handle">{{ '@' . $user->username }}</span>

            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-value">{{ $user->posts ? $user->posts->count() : 0 }}</span>
                    <span class="stat-label">Published Stories</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $user->created_at->format('Y') }}</span>
                    <span class="stat-label">Member Since</span>
                </div>
            </div>

            <div class="details-list">
                <div class="detail-row">
                    <span class="detail-label">Email Address</span>
                    <span class="detail-value">{{ $user->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Account Status</span>
                    <span class="detail-value" style="color: #16a34a;">Active</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button class="logout-btn" type="submit">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>

        </div>

    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }
    </script>
</body>
</html>
