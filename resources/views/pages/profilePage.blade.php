<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} — Shabd Profile</title>
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

        /* --- Profile Layout --- */
        .profile-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        /* Identity Section */
        .identity-card {
            text-align: center;
            margin-bottom: 3rem;
        }

        .avatar-wrapper {
            width: 100px; height: 100px;
            margin: 0 auto 1.5rem auto;
            border-radius: 50%;
            padding: 3px;
            border: 1px solid var(--border-line);
        }
        .avatar-img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }

        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--ink-primary);
            margin-bottom: 0.5rem;
        }

        .profile-username {
            font-size: 1rem;
            color: var(--ink-secondary);
            font-family: 'DM Sans', sans-serif;
            margin-bottom: 1.5rem;
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            border-top: 1px solid var(--border-line);
            border-bottom: 1px solid var(--border-line);
            padding: 1rem 0;
        }

        .stat-btn {
            background: none; border: none; cursor: pointer;
            text-align: center; color: var(--ink-primary);
        }
        .stat-val { font-weight: 700; font-size: 1.1rem; display: block; }
        .stat-lbl { font-size: 0.8rem; color: var(--ink-secondary); text-transform: uppercase; letter-spacing: 0.05em; }

        /* Follow Button */
        .action-area { margin-bottom: 3rem; display: flex; justify-content: center; }
        .btn-action {
            padding: 10px 24px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-follow { background: var(--ink-primary); color: white; border: 1px solid var(--ink-primary); }
        .btn-follow:hover { background: var(--accent-color); border-color: var(--accent-color); }
        .btn-unfollow { background: transparent; color: var(--ink-primary); border: 1px solid var(--border-line); }
        .btn-unfollow:hover { border-color: var(--accent-color); color: var(--accent-color); }

        /* Tabs */
        .tabs-nav {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-line);
        }
        .tab-link {
            padding-bottom: 10px;
            cursor: pointer;
            font-weight: 600;
            color: var(--ink-secondary);
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        .tab-link.active {
            color: var(--ink-primary);
            border-bottom-color: var(--ink-primary);
        }

        /* Post Grid */
        .posts-grid {
            display: flex; flex-direction: column; gap: 1.5rem;
        }
        .post-item {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            padding: 1.5rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .post-item:hover { transform: translateY(-2px); border-color: var(--ink-primary); }
        
        .post-item h3 { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--ink-primary); margin-bottom: 0.5rem; }
        .post-item p { font-size: 0.95rem; color: var(--ink-secondary); line-height: 1.5; margin-bottom: 1rem; }
        .post-item-meta { font-size: 0.8rem; color: var(--ink-secondary); text-transform: uppercase; }

        /* Modal Styles */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); z-index: 2000;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(2px);
        }
        .modal-box {
            background: var(--card-bg); width: 90%; max-width: 400px;
            border-radius: var(--radius-sharp); padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-height: 70vh; overflow-y: auto;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-line); padding-bottom: 0.5rem; }
        .modal-title { font-family: 'Playfair Display'; font-weight: 700; font-size: 1.2rem; }
        .modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--ink-secondary); }
        
        .user-row {
            display: flex; align-items: center; gap: 10px; padding: 10px 0;
            text-decoration: none; color: var(--ink-primary); border-bottom: 1px solid var(--border-line);
        }
        .user-row:last-child { border-bottom: none; }
        .user-row:hover .row-name { color: var(--accent-color); }
        .row-name { font-weight: 600; display: block; font-size: 0.95rem; }
        .row-handle { font-size: 0.8rem; color: var(--ink-secondary); }

        .about-text {
            color: var(--ink-secondary); line-height: 1.6; text-align: center; max-width: 600px; margin: 0 auto;
        }

    </style>
</head>

<body>
    @php 
        $loggedInUser = Auth::user(); 
        $isOwnProfile = $loggedInUser && $loggedInUser->id === $user->id;
    @endphp

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    @auth
    <aside class="sidebar" id="sidebar">
        <button onclick="toggleSidebar()" style="background:none; border:none; align-self:flex-end; font-size:1.2rem; cursor:pointer;">&times;</button>
        <div style="font-family:'Playfair Display'; font-weight:700; font-size:1.5rem; margin-bottom:1rem;">Shabd.</div>
        <a href="{{ route('home.page') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('notifications.page') }}"><i class="fas fa-bell"></i> Notifications @if($loggedInUser->unreadNotifications->count() > 0) <span class="nav-badge">{{ $loggedInUser->unreadNotifications->count() }}</span> @endif</a>
        <a href="{{ route('dashboard.page') }}"><i class="fas fa-file-alt"></i> My Posts</a>
        <a href="{{ route('post.add.page') }}"><i class="fas fa-plus-circle"></i> Create Post</a>
        <a href="{{ route('profile.page') }}"><i class="fas fa-user"></i> Profile</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-top:auto; color:var(--accent-color);">Sign Out</a>
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
            <a href="{{ route('home.page') }}">Discover</a>
            @guest
                <a href="{{ route('login.page') }}">Sign In</a>
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
                <span class="stat-val">{{ $user->followers_count }}</span>
                <span class="stat-lbl">Followers</span>
            </button>
            <button class="stat-btn" onclick="openModal('followingModal')">
                <span class="stat-val">{{ $user->followings_count }}</span>
                <span class="stat-lbl">Following</span>
            </button>
            <div class="stat-btn" style="cursor: default;">
                <span class="stat-val">{{ $user->posts->count() }}</span>
                <span class="stat-lbl">Stories</span>
            </div>
        </div>

        @auth
            @if (!$isOwnProfile)
                <div class="action-area">
                    @if ($isFollowing)
                        <form method="POST" action="{{ route('unfollow', $user->id) }}">
                            @csrf
                            <button class="btn-action btn-unfollow">Unfollow</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('follow', $user->id) }}">
                            @csrf
                            <button class="btn-action btn-follow">Follow</button>
                        </form>
                    @endif
                </div>
            @endif
        @endauth

        <div class="tabs-nav">
            <div class="tab-link active" onclick="switchTab('posts')">Stories</div>
            <div class="tab-link" onclick="switchTab('about')">About</div>
        </div>

        <div id="posts-tab" class="posts-grid">
            @forelse ($user->posts as $post)
                <a href="{{ route('post.page', $post->id) }}" class="post-item">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ Str::limit($post->description, 140) }}</p>
                    <div class="post-item-meta">{{ $post->created_at->format('M d, Y') }}</div>
                </a>
            @empty
                <div style="text-align:center; padding:3rem; color:var(--ink-secondary);">
                    <i class="far fa-folder-open" style="font-size:2rem; opacity:0.3; margin-bottom:1rem;"></i>
                    <p>No stories published yet.</p>
                </div>
            @endforelse
        </div>

        <div id="about-tab" style="display: none;">
            <div class="about-text">
                <p>Member since {{ $user->created_at->format('F Y') }}.</p>
                <p>{{ $user->email }}</p>
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
                <p style="text-align:center; color:var(--ink-secondary);">No followers yet.</p>
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
                <p style="text-align:center; color:var(--ink-secondary);">Not following anyone.</p>
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

        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        
        // Close modal on click outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
</body>
</html>