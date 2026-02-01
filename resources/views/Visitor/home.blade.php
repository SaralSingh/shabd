<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shabd • Share what you know</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
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
            /* Grain Texture */
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            color: var(--ink-primary);
            overflow-x: hidden;
        }

        /* --- Navigation --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ink-primary);
            text-decoration: none;
            letter-spacing: -0.03em;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-item {
            text-decoration: none;
            color: var(--ink-primary);
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-item:hover { color: var(--accent-color); }

        .btn-nav {
            padding: 0.6rem 1.2rem;
            border: 1px solid var(--ink-primary);
            border-radius: var(--radius-sharp);
            color: var(--ink-primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-nav:hover {
            background: var(--ink-primary);
            color: white;
        }

        /* --- Hero Section --- */
        .hero-container {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 55% 45%;
        }

        /* Left: Content */
        .hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 3rem 3rem 6rem; /* Left padding larger */
        }

        .hero-tagline {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--ink-primary);
        }

        .hero-title span {
            font-style: italic;
            opacity: 0.7;
        }

        .hero-desc {
            font-size: 1.2rem;
            line-height: 1.6;
            color: var(--ink-secondary);
            max-width: 500px;
            margin-bottom: 2.5rem;
        }

        .cta-group {
            display: flex;
            gap: 1.5rem;
        }

        .btn-primary {
            background-color: var(--ink-primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: var(--radius-sharp);
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .btn-primary:hover { background-color: var(--accent-color); }

        .btn-secondary {
            display: flex;
            align-items: center;
            color: var(--ink-primary);
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: border-color 0.3s;
        }
        .btn-secondary:hover { border-bottom-color: var(--ink-primary); }
        .arrow-icon { margin-left: 8px; transition: transform 0.2s; }
        .btn-secondary:hover .arrow-icon { transform: translateX(5px); }

        /* Right: Visual */
        .hero-visual {
            background-color: var(--ink-primary);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Abstract Art Element */
        .visual-circle {
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.02));
            position: absolute;
        }
        
        /* A subtle line pattern overlay */
        .hero-visual::before {
            content: '';
            position: absolute;
            width: 100%; height: 100%;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.03) 10px, rgba(255,255,255,0.03) 11px);
        }

        .visual-text {
            position: relative;
            z-index: 10;
            color: white;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            opacity: 0.1;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
        }

        /* --- Footer --- */
        .footer {
            border-top: 1px solid var(--border-line);
            padding: 2rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--ink-secondary);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .navbar { padding: 1.5rem; }
            .hero-container { grid-template-columns: 1fr; }
            .hero-content { padding: 8rem 2rem 4rem 2rem; text-align: center; align-items: center; }
            .hero-title { font-size: 3rem; }
            .hero-visual { min-height: 300px; }
            .visual-text { font-size: 4rem; transform: rotate(0); writing-mode: horizontal-tb; }
            .footer { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="/" class="logo">Shabd.</a>
        <div class="nav-links">
            <a href="{{ route('login.page') }}" class="nav-item">Sign In</a>
            <a href="{{ route('register.page') }}" class="btn-nav">Start Writing</a>
        </div>
    </nav>

    <section class="hero-container">
        
        <div class="hero-content">
            <span class="hero-tagline">Share what you know</span>
            <h1 class="hero-title">
                Words, pure <br> and <span>simple.</span>
            </h1>
            <p class="hero-desc">
                A minimalist publishing platform designed for clarity. 
                Pair your text with a single image and publish under your own name. 
                No clutter, just your voice.
            </p>
            
            <div class="cta-group">
                <a href="/posts" class="btn-primary">Start Reading</a>
                <a href="{{ route('register.page') }}" class="btn-secondary">
                    Join the Community 
                    <span class="arrow-icon">→</span>
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="visual-circle"></div>
            <div class="visual-text">SHABD</div>
        </div>

    </section>

    <footer class="footer">
        <div>© 2026 Shabd Platform.</div>
        <div>Designed for Writers.</div>
    </footer>

</body>
</html>