<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Story — Shabd Studio</title>
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

        /* --- Editor Layout --- */
        .editor-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        .editor-header {
            margin-bottom: 2rem;
            border-bottom: 1px dashed var(--border-line);
            padding-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .editor-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ink-primary);
        }

        .editor-card {
            background: var(--card-bg);
            border: 1px solid var(--border-line);
            border-radius: var(--radius-sharp);
            padding: 3rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }

        /* Form Inputs */
        .form-group {
            position: relative;
            margin-bottom: 2.5rem;
        }

        /* Clean Input Style */
        .input-field {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--border-line);
            padding: 10px 0;
            font-size: 1.1rem;
            color: var(--ink-primary);
            transition: border-color 0.3s;
            border-radius: 0;
        }

        .input-field:focus {
            outline: none;
            border-bottom-color: var(--ink-primary);
        }

        /* Textarea specific */
        textarea.input-field {
            resize: vertical;
            min-height: 300px;
            line-height: 1.6;
            font-family: 'DM Sans', sans-serif;
        }

        /* Floating Label Logic */
        .input-label {
            position: absolute;
            top: 10px;
            left: 0;
            font-size: 1rem;
            color: var(--ink-secondary);
            pointer-events: none;
            transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
        }

        /* Active State for Label (When input has value or focus) */
        .input-field:focus ~ .input-label,
        .input-field:valid ~ .input-label {
            top: -15px;
            font-size: 0.75rem;
            color: var(--accent-color);
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Buttons */
        .action-row {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 2rem;
        }

        .btn {
            padding: 12px 24px;
            border-radius: var(--radius-sharp);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid var(--border-line);
            color: var(--ink-secondary);
        }
        .btn-cancel:hover { border-color: var(--ink-secondary); color: var(--ink-primary); }

        .btn-submit {
            background: var(--ink-primary);
            color: white;
            border: none;
        }
        .btn-submit:hover { background: var(--accent-color); }

        .error-msg {
            color: #e11d48;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 600px) {
            .editor-card { padding: 1.5rem; }
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
        <div class="nav-actions" style="font-size:0.9rem; color:var(--ink-secondary);">
            Drafting...
        </div>
    </nav>

    <main class="editor-container">
        
        <header class="editor-header">
            <h1 class="editor-title">Edit Story</h1>
            <a href="{{ route('dashboard.page') }}" style="color:var(--ink-secondary); text-decoration:none; font-size:0.9rem;">Cancel</a>
        </header>

        <div class="editor-card">
            
            <form action="{{ route('post.edit') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <div class="form-group">
                    <input type="text" name="title" id="title" class="input-field" 
                           value="{{ old('title', $post->title) }}" required>
                    <label for="title" class="input-label">Headline</label>
                    @error('title') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <textarea name="description" id="description" class="input-field" 
                              required>{{ old('description', $post->description) }}</textarea>
                    <label for="description" class="input-label">Tell your story...</label>
                    @error('description') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="action-row">
                    <button type="reset" class="btn btn-cancel">Reset Changes</button>
                    <button type="submit" class="btn btn-submit">Update Story</button>
                </div>

            </form>

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