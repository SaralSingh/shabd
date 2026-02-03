<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Archive — Shabd</title>
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
  
        /* --- Dashboard Layout --- */
        .dashboard-container {
            max-width: 900px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        .dashboard-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-line);
        }

        .dashboard-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink-primary);
            line-height: 1;
        }

        /* Search Bar */
        .search-wrapper {
            position: relative;
            max-width: 300px;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid var(--border-line);
            border-radius: 50px;
            background: var(--card-bg);
            font-size: 0.9rem;
            color: var(--ink-primary);
            font-family: 'DM Sans', sans-serif;
        }
        .search-input:focus { outline: none; border-color: var(--ink-primary); }
        .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--ink-secondary); font-size: 0.8rem; }

        /* Post List */
        .post-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .post-card {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            padding: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border-color: var(--ink-primary);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
        }

        .post-title-link {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--ink-primary);
            text-decoration: none;
            line-height: 1.2;
        }
        .post-title-link:hover { text-decoration: underline; }

        .post-date {
            font-size: 0.8rem;
            color: var(--ink-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .post-excerpt {
            font-size: 0.95rem;
            color: var(--ink-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .post-footer {
            border-top: 1px dashed var(--border-line);
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-group {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: var(--ink-secondary);
        }
        .stats-group i { margin-right: 5px; opacity: 0.7; }

        .action-group {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-view { color: var(--ink-primary); background: rgba(0,0,0,0.05); }
        .btn-view:hover { background: rgba(0,0,0,0.1); }

        .btn-edit { color: #059669; background: rgba(16, 185, 129, 0.1); }
        .btn-edit:hover { background: rgba(16, 185, 129, 0.2); }

        .btn-delete { color: #e11d48; background: rgba(225, 29, 72, 0.1); border: none; cursor: pointer; }
        .btn-delete:hover { background: rgba(225, 29, 72, 0.2); }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--ink-secondary);
        }
        .empty-state img { width: 100px; opacity: 0.5; margin-bottom: 1rem; filter: grayscale(1); }

        /* Toast */
        .custom-toast {
            position: fixed; top: 20px; right: 20px;
            background: var(--ink-primary); color: white;
            padding: 1rem 1.5rem; border-radius: var(--radius-sharp);
            display: none; z-index: 2000;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        @media (max-width: 600px) {
            .dashboard-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .search-wrapper { max-width: 100%; }
            .post-footer { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .action-group { width: 100%; justify-content: flex-end; }
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

    <main class="dashboard-container">
        
        <header class="dashboard-header">
            <h1 class="dashboard-title">My Archive</h1>
            
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" class="search-input" 
                       placeholder="Filter by title..." onkeyup="filterPosts()">
            </div>
        </header>

        <div id="postContainer" class="post-list">
            @foreach ($posts as $post)
                <article class="post-card" data-title="{{ strtolower($post->title) }}">
                    
                    <div class="post-header">
                        <a href="{{ route('post.page', ['id' => $post->id]) }}" class="post-title-link">
                            {{ $post->title }}
                        </a>
                        <span class="post-date">{{ $post->created_at->format('M j') }}</span>
                    </div>

                    <p class="post-excerpt">
                        {{ Str::limit($post->description, 140, '...') }}
                    </p>

                    <div class="post-footer">
                        <div class="stats-group">
                            <span title="Likes"><i class="fas fa-thumbs-up"></i> {{ $post->likes }}</span>
                            <span title="Comments"><i class="far fa-comment"></i> {{ $post->comments }}</span>
                        </div>

                        <div class="action-group">
                            <a href="{{ route('user.post.view', $post->id) }}" class="btn-icon btn-view">View</a>
                            <a href="{{ route('post.edit.page', $post->id) }}" class="btn-icon btn-edit">Edit</a>
                            
                            <form action="{{ route('post.delete', $post->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this story? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>

                </article>
            @endforeach
        </div>

        <div id="notFound" class="empty-state" style="display: none;">
            <i class="fas fa-search" style="font-size: 2rem; opacity: 0.3; margin-bottom: 1rem;"></i>
            <p>No stories found matching your search.</p>
        </div>

    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">@csrf</form>

    @if (session('success'))
        <div id="flash-toast" class="custom-toast" style="display: block;">
            {{ session('success') }}
        </div>
    @endif

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }

        // Hide toast after 3s
        setTimeout(() => {
            const t = document.getElementById('flash-toast');
            if(t) t.style.display = 'none';
        }, 3000);

        // Filter Logic
        function filterPosts() {
            const input = document.getElementById('searchInput').value.trim().toLowerCase();
            const posts = document.querySelectorAll('.post-card');
            let found = false;

            posts.forEach(post => {
                const title = post.dataset.title;
                if (title.includes(input)) {
                    post.style.display = "block";
                    found = true;
                } else {
                    post.style.display = "none";
                }
            });

            const emptyState = document.getElementById('notFound');
            if (!found && input !== '') {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
    </script>
</body>
</html>