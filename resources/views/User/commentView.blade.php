<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments: {{ $post->title }} — Shabd</title>
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

        /* --- Comment Thread Layout --- */
        .comments-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        .header-section {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed var(--border-line);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ink-primary);
            margin-bottom: 0.5rem;
        }

        .post-ref {
            font-size: 0.9rem;
            color: var(--ink-secondary);
        }
        .post-ref strong { color: var(--ink-primary); }

        /* Comment Cards */
        .comment-card {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        /* Thread styling for nested comments */
        .nested-thread {
            margin-left: 2rem;
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 2px solid rgba(0,0,0,0.05);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.8rem;
        }

        .user-info {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--accent-color);
        }
        .user-info.is-me { color: var(--ink-primary); }
        .user-badge {
            font-size: 0.7rem;
            background: rgba(0,0,0,0.05);
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 5px;
            color: var(--ink-secondary);
            font-weight: normal;
        }

        .comment-body {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--ink-primary);
            margin-bottom: 0.8rem;
        }

        .comment-meta {
            font-size: 0.8rem;
            color: var(--ink-secondary);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Buttons */
        .btn-toggle {
            background: transparent;
            border: 1px solid var(--border-line);
            color: var(--ink-secondary);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-toggle:hover {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .btn-delete {
            background: transparent;
            border: none;
            color: #e11d48;
            font-size: 0.8rem;
            cursor: pointer;
            padding: 0;
            font-weight: 500;
        }
        .btn-delete:hover { text-decoration: underline; }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            text-decoration: none;
            color: var(--ink-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }
        .back-link:hover { color: var(--ink-primary); }

        @media (max-width: 600px) {
            .nested-thread { margin-left: 1rem; padding-left: 0.5rem; }
        }
    </style>
</head>

<body>
    @php 
        $user = Auth::user(); 
        $authId = Auth::id();
    @endphp

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    <aside class="sidebar" id="sidebar">
        <button onclick="toggleSidebar()" style="background:none; border:none; align-self:flex-end; font-size:1.2rem; cursor:pointer;">&times;</button>
        <div style="font-family:'Playfair Display'; font-weight:700; font-size:1.5rem; margin-bottom:1rem;">Shabd.</div>
        <a href="{{ route('home.page') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('notifications.page') }}"><i class="fas fa-bell"></i> Notifications @if($user->unreadNotifications->count() > 0) <span class="nav-badge">{{ $user->unreadNotifications->count() }}</span> @endif</a>
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

    <main class="comments-container">
        
        <div class="header-section">
            <h1 class="page-title">Discussion Thread</h1>
            <p class="post-ref">Regarding: <strong>{{ $post->title }}</strong></p>
        </div>

        @if ($comments->count())
            @foreach ($comments as $comment)
                <div class="comment-card">
                    
                    <div class="comment-header">
                        <div class="user-info {{ $comment->user_id === $authId ? 'is-me' : '' }}">
                            {{ $comment->user->username ?? 'Unknown' }}
                            @if($comment->user_id === $authId)
                                <span class="user-badge">You</span>
                            @endif
                        </div>

                        @if($comment->user_id === $authId)
                            <form action="{{ route('comment.delete', $comment->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Delete this comment?')">Delete</button>
                            </form>
                        @endif
                    </div>

                    <div class="comment-body">
                        {{ $comment->comment }}
                    </div>

                    <div class="comment-meta">
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                        
                        @if ($comment->repliesRecursive && $comment->repliesRecursive->count())
                            @php $replyId = 'reply-group-' . $comment->id; @endphp
                            <button onclick="toggleReplies('{{ $replyId }}', this)" class="btn-toggle" style="margin-left: auto;">
                                <span>Show {{ $comment->repliesRecursive->count() }} Replies</span> <i class="fas fa-chevron-down"></i>
                            </button>
                        @endif
                    </div>

                    @if ($comment->repliesRecursive && $comment->repliesRecursive->count())
                        <div id="{{ $replyId }}" class="nested-thread" style="display: none;">
                            @php renderReplies($comment->repliesRecursive, $authId); @endphp
                        </div>
                    @endif

                </div>
            @endforeach
        @else
            <div style="text-align: center; color: var(--ink-secondary); padding: 2rem;">
                No comments yet on this post.
            </div>
        @endif

        <a href="{{ route('user.post.view', [$post->id]) }}" class="back-nav back-link">
            <i class="fas fa-arrow-left"></i> Return to Post
        </a>

    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">@csrf</form>

    @php
        function renderReplies($replies, $authId) {
            foreach ($replies as $reply) {
                $replyId = 'reply-group-' . $reply->id;
                echo '<div class="comment-card" style="background: #fafafa; border:none; border-left: 2px solid var(--accent-color); border-radius:0; margin-bottom: 1rem;">';
                
                // Header
                echo '<div class="comment-header">';
                echo '<div class="user-info ' . ($reply->user_id === $authId ? 'is-me' : '') . '">' . ($reply->user->username ?? 'Unknown');
                if ($reply->user_id === $authId) echo ' <span class="user-badge">You</span>';
                echo '</div>';
                
                // Delete Button
                if ($reply->user_id === $authId) {
                    echo '<form action="' . route('comment.delete', $reply->id) . '" method="POST">';
                    echo csrf_field() . method_field('DELETE');
                    echo '<button type="submit" class="btn-delete" onclick="return confirm(\'Delete?\')">Delete</button>';
                    echo '</form>';
                }
                echo '</div>';

                // Content
                echo '<div class="comment-body">' . e($reply->comment) . '</div>';
                echo '<div class="comment-meta">' . $reply->created_at->diffForHumans();

                // Nested Toggle
                if ($reply->repliesRecursive && $reply->repliesRecursive->count()) {
                    echo '<button onclick="toggleReplies(\'' . $replyId . '\', this)" class="btn-toggle" style="margin-left: auto;">';
                    echo 'Show ' . $reply->repliesRecursive->count() . ' Replies <i class="fas fa-chevron-down"></i>';
                    echo '</button>';
                }
                echo '</div>'; // End Meta

                // Nested Container
                if ($reply->repliesRecursive && $reply->repliesRecursive->count()) {
                    echo '<div id="' . $replyId . '" class="nested-thread" style="display: none;">';
                    renderReplies($reply->repliesRecursive, $authId);
                    echo '</div>';
                }

                echo '</div>'; // End Card
            }
        }
    @endphp

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('show');
        }

        function toggleReplies(id, btn) {
            const el = document.getElementById(id);
            const icon = btn.querySelector('i');
            const span = btn.querySelector('span');
            
            if (el.style.display === 'none') {
                el.style.display = 'block';
                span.innerText = span.innerText.replace("Show", "Hide");
                icon.className = "fas fa-chevron-up";
            } else {
                el.style.display = 'none';
                span.innerText = span.innerText.replace("Hide", "Show");
                icon.className = "fas fa-chevron-down";
            }
        }
    </script>
</body>
</html>