<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} — Shabd Studio</title>
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

        /* --- Navbar & Sidebar --- */
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

        /* --- Viewer Layout --- */
        .viewer-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        .back-nav {
            margin-bottom: 2rem;
            display: inline-block;
            text-decoration: none;
            color: var(--ink-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }
        .back-nav:hover { color: var(--accent-color); }

        .manuscript-card {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            padding: 4rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        /* Post Content */
        .post-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--ink-primary);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-line);
            margin-bottom: 2rem;
            font-size: 0.85rem;
            color: var(--ink-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .meta-group { display: flex; align-items: center; gap: 15px; }
        .meta-item i { margin-right: 5px; color: var(--accent-color); opacity: 0.8; }

        .post-image {
            width: 100%;
            height: auto;
            border-radius: var(--radius-sharp);
            margin-bottom: 2.5rem;
            border: 1px solid var(--border-line);
        }

        .post-body {
            font-family: 'DM Sans', sans-serif; /* Clean sans for dashboard view, or Serif if you prefer reading mode */
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
            white-space: pre-line;
            margin-bottom: 3rem;
        }

        /* Actions Footer */
        .post-footer {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px dashed var(--border-line);
            display: flex;
            gap: 15px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sharp);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-comments {
            background-color: rgba(0,0,0,0.04);
            color: var(--ink-primary);
        }
        .btn-comments:hover { background-color: var(--ink-primary); color: white; }

        .btn-edit {
            border: 1px solid var(--border-line);
            color: var(--ink-secondary);
        }
        .btn-edit:hover { border-color: var(--ink-primary); color: var(--ink-primary); }

        @media (max-width: 768px) {
            .manuscript-card { padding: 2rem; }
            .post-title { font-size: 1.8rem; }
            .post-meta { flex-direction: column; align-items: flex-start; gap: 10px; }
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
        <a href="{{ route('notifications.page') }}"><i class="fas fa-bell"></i> Notifications @if($user->unreadNotifications->count() > 0) <span class="nav-badge">{{ $user->unreadNotifications->count() }}</span> @endif</a>
        <a href="{{ route('dashboard.page') }}" class="active"><i class="fas fa-file-alt"></i> My Posts</a>
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
            <a href="{{ route('home.page') }}">Discover</a>
            <a href="{{ route('post.add.page') }}">Write</a>
            <a href="{{ route('dashboard.page') }}">Dashboard</a>
        </div>
    </nav>

    <div class="viewer-container">
        
        <a href="{{ route('dashboard.page') }}" class="back-nav">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="manuscript-card">
            
            <h1 class="post-title">{{ $post->title }}</h1>

            <div class="post-meta">
                <div class="meta-group">
                    <span class="meta-item"><i class="fas fa-user-circle"></i> {{ $post->user->name }}</span>
                    <span class="meta-item" style="text-transform: lowercase; opacity: 0.7;">{{ '@' . $post->user->username }}</span>
                </div>
                <div class="meta-group">
                    <span class="meta-item"><i class="fas fa-calendar-day"></i> {{ $post->created_at->format('F j, Y') }}</span>
                </div>
            </div>

            @if($post->picture)
                <img src="{{ asset('storage/' . $post->picture) }}" alt="Post Image" class="post-image">
            @endif

            <div class="post-body">
                {{ $post->description }}
            </div>

            <div class="post-footer">
                <a href="{{ route('viewComment', ['id' => $post->id]) }}" class="action-btn btn-comments">
                    <i class="far fa-comments"></i> 
                    Manage Comments 
                    <strong style="margin-left:5px; opacity:0.6;">{{ $post->comments->count() }}</strong>
                </a>

                <a href="{{ route('post.edit.page', ['id' => $post->id]) }}" class="action-btn btn-edit">
                    <i class="far fa-edit"></i> Edit Post
                </a>
            </div>

        </div>

    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
        @csrf
    </form>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }
    </script>
</body>
</html>