<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Shabd</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* SHABD Design System */
            --ink-primary: #1c1c1e;       /* Almost Black */
            --ink-secondary: #52525b;     /* Dark Grey */
            --paper-bg: #f5f5f0;          /* Warm Grey/Beige */
            --card-bg: #ffffff;
            --accent-color: #bc4749;      /* Muted Terracotta Red */
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-card {
            background: var(--card-bg);
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            display: grid;
            grid-template-columns: 40% 60%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.02);
            border-radius: var(--radius-sharp);
            overflow: hidden;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* --- Left Side: The "Book Jacket" --- */
        .brand-panel {
            background-color: var(--ink-primary);
            color: #e5e5e5;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .brand-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: #fff;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .brand-header span {
            font-family: 'DM Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            font-size: 0.75rem;
            opacity: 0.6;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 10px;
            display: inline-block;
        }

        .quote-box {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.25rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* --- Right Side: The Form --- */
        .form-panel {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header { margin-bottom: 2.5rem; }
        
        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--ink-primary);
            margin-bottom: 0.5rem;
        }
        
        .form-header p { color: var(--ink-secondary); font-size: 0.95rem; }

        /* Inputs - Clean Bottom Border Style */
        .input-group { margin-bottom: 1.8rem; position: relative; }
        
        .input-group label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--ink-secondary);
        }

        .input-group input {
            width: 100%;
            padding: 0.8rem 0;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            color: var(--ink-primary);
            border: none;
            border-bottom: 1px solid var(--border-line); /* Underline Style */
            background: transparent;
            transition: border-color 0.3s ease;
            border-radius: 0;
        }

        .input-group input:focus {
            outline: none;
            border-bottom-color: var(--ink-primary);
        }

        /* Button */
        .btn-submit {
            background-color: var(--ink-primary);
            color: white;
            padding: 1rem;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            border: none;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.3s ease, transform 0.2s;
            border-radius: var(--radius-sharp);
            font-size: 1rem;
        }

        .btn-submit:hover {
            background-color: var(--accent-color);
        }

        /* Utilities */
        .alert {
            padding: 12px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            background: #fef2f2;
            color: #991b1b;
            border-left: 3px solid #991b1b;
        }
        .error-txt { font-size: 0.8rem; color: #b91c1c; margin-top: 5px; }
        
        .helper-links {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }
        .link { color: var(--ink-secondary); text-decoration: none; transition: color 0.2s; }
        .link:hover { color: var(--accent-color); text-decoration: underline; }
        .link.bold { font-weight: 700; color: var(--ink-primary); }

        /* Footer inside Form */
        .mini-footer {
            margin-top: 3rem;
            border-top: 1px solid var(--border-line);
            padding-top: 1.5rem;
        }
        .mini-footer-links { 
            display: flex; 
            gap: 20px; 
            font-size: 0.8rem; 
            color: var(--ink-secondary); 
            flex-wrap: wrap;
        }
        .mini-footer-links a { text-decoration: none; color: inherit; }
        .mini-footer-links a:hover { color: var(--ink-primary); }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 900px) {
            .main-card { grid-template-columns: 1fr; min-height: auto; max-width: 500px; }
            .brand-panel { padding: 2.5rem; align-items: center; text-align: center; }
            .brand-header h1 { font-size: 2.5rem; }
            .quote-box { display: none; }
            .form-panel { padding: 2.5rem; }
            body { overflow-y: auto; }
        }
    </style>
</head>
<body>

    <main class="main-card">
        <div class="brand-panel">
            <div class="brand-header">
                <h1>Shabd.</h1>
                <span>Share what you know</span>
            </div>
            
            <div class="quote-box">
                "Either write something worth reading or do something worth writing."
            </div>
        </div>

        <div class="form-panel">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Sign in to continue your writing journey.</p>
            </div>

            @if(session('error'))
                <div class="alert">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login.check') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="writer@example.com">
                    @error('email') <div class="error-txt">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required placeholder="•••••••••">
                    @error('password') <div class="error-txt">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn-submit">Read & Write</button>

                <div class="helper-links">
                    <a href="#" class="link">Forgot password?</a>
                    <span>New here? <a href="{{ route('register.page') }}" class="link bold">Join Shabd</a></span>
                </div>
            </form>

            <div class="mini-footer">
                <div class="mini-footer-links">
                    <a href="#">Manifesto</a>
                    <a href="#">Writing Tips</a>
                    <a href="#">Community Guidelines</a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>