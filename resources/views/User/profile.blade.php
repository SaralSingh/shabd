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
  

        /* --- Profile Layout --- */
        .profile-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        .identity-card { text-align: center; margin-bottom: 3rem; }
        
        .avatar-wrapper {
            width: 100px; height: 100px; margin: 0 auto 1.5rem auto;
            border-radius: 50%; padding: 3px; border: 1px solid var(--border-line);
        }
        .avatar-img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }

        .profile-name {
            font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700;
            color: var(--ink-primary); margin-bottom: 0.5rem;
        }
        .profile-username { font-size: 1rem; color: var(--ink-secondary); margin-bottom: 1.5rem; }

        /* Stats Bar (Clickable) */
        .stats-bar {
            display: flex; justify-content: center; gap: 2rem;
            border-top: 1px solid var(--border-line);
            border-bottom: 1px solid var(--border-line);
            padding: 1rem 0; margin-bottom: 2rem;
        }
        .stat-btn {
            background: none; border: none; cursor: pointer; text-align: center; color: var(--ink-primary);
        }
        .stat-val { font-weight: 700; font-size: 1.1rem; display: block; }
        .stat-lbl { font-size: 0.8rem; color: var(--ink-secondary); text-transform: uppercase; letter-spacing: 0.05em; }

        /* Tabs */
        .tabs-nav {
            display: flex; justify-content: center; gap: 2rem; margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-line);
        }
        .tab-link {
            padding-bottom: 10px; cursor: pointer; font-weight: 600;
            color: var(--ink-secondary); border-bottom: 2px solid transparent;
        }
        .tab-link.active { color: var(--ink-primary); border-bottom-color: var(--ink-primary); }

        /* Content Areas */
        .posts-grid { display: flex; flex-direction: column; gap: 1.5rem; }
        .post-item {
            background: var(--card-bg); border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp); padding: 1.5rem;
            text-decoration: none; display: block;
            transition: transform 0.2s;
        }
        .post-item:hover { transform: translateY(-2px); border-color: var(--ink-primary); }
        .post-item h3 { font-family: 'Playfair Display'; font-size: 1.3rem; color: var(--ink-primary); margin-bottom: 0.5rem; }
        .post-item p { font-size: 0.95rem; color: var(--ink-secondary); margin-bottom: 1rem; }
        .post-item-meta { font-size: 0.8rem; color: var(--ink-secondary); text-transform: uppercase; }

        .about-text { text-align: center; color: var(--ink-secondary); line-height: 1.6; }
        .logout-area { margin-top: 3rem; text-align: center; border-top: 1px dashed var(--border-line); padding-top: 2rem; }
        .logout-btn {
            background: transparent; border: 1px solid var(--accent-color); color: var(--accent-color);
            padding: 10px 24px; border-radius: 30px; font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        .logout-btn:hover { background: var(--accent-color); color: white; }

        /* Modals */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); z-index: 2000;
            display: none; align-items: center; justify-content: center; backdrop-filter: blur(2px);
        }
        .modal-box {
            background: var(--card-bg); width: 90%; max-width: 400px;
            border-radius: var(--radius-sharp); padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-height: 70vh; overflow-y: auto;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid var(--border-line); padding-bottom: 0.5rem; }
        .modal-title { font-family: 'Playfair Display'; font-weight: 700; font-size: 1.2rem; }
        .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; }
        
        .user-row {
            display: flex; align-items: center; gap: 10px; padding: 10px 0; text-decoration: none;
            border-bottom: 1px solid var(--border-line);
        }
        .row-name { font-weight: 600; display: block; color: var(--ink-primary); }
        .row-handle { font-size: 0.8rem; color: var(--ink-secondary); }

        @media (max-width: 600px) { .profile-container { padding: 0 15px; } }
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

                <a href="{{ route('post.add.page') }}" class="{{ request()->is('user/account/create/post') ? 'active-link' : '' }}">Write</a>
                <a href="{{ route('dashboard.page') }}" class="{{ request()->is('user/account/posts') ? 'active-link' : '' }}">My Posts</a>
                
                <a href="{{ route('profile.page') }}" style="font-weight:700;" class="{{ request()->is('user/account/profile') ? 'active-link' : '' }}">{{ Auth::user()->username }}</a>
                
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:var(--accent-color);">Sign Out</a>
            @else
                <a href="{{ route('login.page') }}">Sign In</a>
                <a href="{{ route('register.page') }}" style="font-weight:700;">Join</a>
            @endguest
        </div>
    </nav>

    <main class="profile-container">
        
        <div class="identity-card">
            <div class="avatar-wrapper">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=random' }}" 
                     alt="Avatar" class="avatar-img">
            </div>
            <h1 class="profile-name">{{ $user->name }}</h1>
            <div class="profile-username">{{ '@' . $user->username }}</div>
        </div>

        <div class="stats-bar">
            <button class="stat-btn" onclick="openModal('followersModal')">
                <span class="stat-val">{{ $user->followers_count ?? $user->followers->count() }}</span>
                <span class="stat-lbl">Followers</span>
            </button>
            <button class="stat-btn" onclick="openModal('followingModal')">
                 <span class="stat-val">{{ $user->followings_count ?? $user->followings->count() }}</span>
                <span class="stat-lbl">Following</span>
            </button>
            <div class="stat-btn" style="cursor: default;">
                <span class="stat-val">{{ $user->posts->count() }}</span>
                <span class="stat-lbl">Stories</span>
            </div>
        </div>

        <div class="tabs-nav">
            <div class="tab-link active" onclick="switchTab('posts')">My Stories</div>
            <div class="tab-link" onclick="switchTab('about')">About Me</div>
        </div>

        <div id="posts-tab" class="posts-grid">
            @forelse ($user->posts as $post)
                <a href="{{ route('post.page', $post->id) }}" class="post-item">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ Str::limit($post->description, 140) }}</p>
                    <div class="post-item-meta">Published: {{ $post->created_at->format('M d, Y') }}</div>
                </a>
            @empty
                <div style="text-align:center; padding:3rem; color:var(--ink-secondary);">
                    <i class="far fa-edit" style="font-size:2rem; opacity:0.3; margin-bottom:1rem;"></i>
                    <p>You haven't published any stories yet.</p>
                    <a href="{{ route('post.add.page') }}" style="color:var(--accent-color); font-weight:600;">Write your first story</a>
                </div>
            @endforelse
        </div>

        <div id="about-tab" style="display: none;">
            <div class="about-text">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Member Since:</strong> {{ $user->created_at->format('F Y') }}</p>
                <p><strong>Status:</strong> <span style="color:#16a34a;">Active Writer</span></p>
            </div>
            
        </div>

    </main>

    <div id="followersModal" class="modal">
        <div class="modal-box">
            <div class="modal-header">
                <span class="modal-title">Followers</span>
                <button class="modal-close" onclick="closeModal('followersModal')">&times;</button>
            </div>
            @forelse ($user->followers as $f)
                <a href="{{ route('user.page', $f->id) }}" class="user-row">
                    <div>
                        <span class="row-name">{{ $f->name }}</span>
                        <span class="row-handle">{{ '@'.$f->username }}</span>
                    </div>
                </a>
            @empty
                <p style="text-align:center; color:var(--ink-secondary); padding:1rem;">You have no followers yet.</p>
            @endforelse
        </div>
    </div>

    <div id="followingModal" class="modal">
        <div class="modal-box">
            <div class="modal-header">
                <span class="modal-title">Following</span>
                <button class="modal-close" onclick="closeModal('followingModal')">&times;</button>
            </div>
            @forelse ($user->followings as $f)
                <a href="{{ route('user.page', $f->id) }}" class="user-row">
                    <div>
                        <span class="row-name">{{ $f->name }}</span>
                        <span class="row-handle">{{ '@'.$f->username }}</span>
                    </div>
                </a>
            @empty
                <p style="text-align:center; color:var(--ink-secondary); padding:1rem;">You are not following anyone.</p>
            @endforelse
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">@csrf</form>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }

        function switchTab(tab) {
            const postsTab = document.getElementById('posts-tab');
            const aboutTab = document.getElementById('about-tab');
            const links = document.querySelectorAll('.tab-link');

            links.forEach(l => l.classList.remove('active'));
            event.target.classList.add('active');

            if(tab === 'posts') {
                postsTab.style.display = 'flex';
                aboutTab.style.display = 'none';
            } else {
                postsTab.style.display = 'none';
                aboutTab.style.display = 'block';
            }
        }

        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
</body>
</html>