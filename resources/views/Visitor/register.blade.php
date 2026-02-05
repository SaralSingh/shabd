<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join Shabd - Share what you know</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* SHABD Design System */
            --ink-primary: #1c1c1e;       /* Almost Black */
            --ink-secondary: #52525b;     /* Dark Grey */
            --paper-bg: #f5f5f0;          /* Warm Grey/Beige */
            --card-bg: #ffffff;
            --accent-color: #bc4749;      /* Muted Terracotta Red */
            --success-color: #10b981;     /* Green for Verify */
            --border-line: #e4e4e7;
            
            --radius-sharp: 4px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--paper-bg);
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            color: var(--ink-primary);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden; 
        }

        .main-card {
            background: var(--card-bg);
            width: 100%;
            max-width: 1100px;
            height: 90vh; 
            display: grid;
            grid-template-columns: 35% 65%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            border-radius: var(--radius-sharp);
            overflow: hidden;
        }

        /* --- Left Side: The "Book Jacket" --- */
        .brand-panel {
            background-color: var(--ink-primary);
            color: #e5e5e5;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .brand-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: #fff;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .brand-header span {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 1rem;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .manifesto {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
            font-style: italic;
        }

        /* --- Right Side: The Form (Scrollable) --- */
        .form-panel {
            padding: 4rem;
            overflow-y: auto; 
            display: flex;
            flex-direction: column;
        }

        .form-header { margin-bottom: 2.5rem; }
        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--ink-primary);
        }
        .form-header p { color: var(--ink-secondary); font-size: 0.95rem; margin-top: 5px; }

        .grid-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .input-group { margin-bottom: 1.8rem; position: relative; }
        
        .input-group label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--ink-secondary);
        }

        .input-group input {
            width: 100%;
            padding: 0.6rem 0;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            color: var(--ink-primary);
            border: none;
            border-bottom: 1px solid var(--border-line);
            background: transparent;
            transition: border-color 0.3s ease;
            border-radius: 0;
        }

        .input-group input:focus {
            outline: none;
            border-bottom-color: var(--ink-primary);
        }

        .input-group input[type="file"] {
            font-size: 0.9rem;
            padding-top: 0.5rem;
        }

        /* OTP Specific Styling */
        .otp-wrapper {
            display: flex;
            align-items: flex-end;
            gap: 15px;
        }
        .otp-wrapper input { flex: 1; }
        
        .btn-otp {
            padding: 0.6rem 1.2rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--ink-primary);
            border: 1px solid var(--border-line);
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .btn-otp:hover {
            border-color: var(--ink-primary);
            background: #fcfcfc;
        }

        /* NEW: Verify Mode Style (Triggers when button changes) */
        .btn-otp.verify-mode {
            background-color: var(--success-color);
            border-color: var(--success-color);
            color: white;
        }
        .btn-otp.verify-mode:hover {
            background-color: #059669; /* Darker green */
        }

        /* Submit Button (Hidden or Disabled initially? 
           Based on your flow, the Verify button submits, 
           so we can keep this or hide it depending on preference) */
        .btn-submit {
            background-color: var(--ink-primary);
            color: white;
            padding: 1.1rem;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            border: none;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.3s ease;
            border-radius: var(--radius-sharp);
            font-size: 1rem;
        }
        .btn-submit:hover { background-color: var(--accent-color); }

        .login-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--ink-secondary);
        }
        .login-link a {
            color: var(--ink-primary);
            text-decoration: none;
            font-weight: 700;
        }
        .login-link a:hover { text-decoration: underline; }

        .error-txt { color: #b91c1c; font-size: 0.75rem; margin-top: 5px; display: block; }

        @media (max-width: 900px) {
            body { height: auto; overflow-y: auto; display: block; }
            .main-card { 
                grid-template-columns: 1fr; 
                height: auto; 
                max-width: 100%; 
                border-radius: 0; 
                box-shadow: none;
            }
            .brand-panel { padding: 3rem 1.5rem; }
            .form-panel { padding: 2rem 1.5rem; overflow: visible; }
            .grid-row { grid-template-columns: 1fr; gap: 0; }
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
            
            <div class="manifesto">
                <p>Welcome to a space designed for clarity.</p>
                <br>
                <p>Compose your thoughts, pair them with a single meaningful image, and publish under your own name. No clutter, just your voice.</p>
            </div>
        </div>

        <div class="form-panel">
            <div class="form-header">
                <h2>Create your account</h2>
                <p>Join the community and start writing today.</p>
            </div>

            <form id="registerForm" method="POST" action="{{ route('register.check') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid-row">
                    <div class="input-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. Arundhati Roy">
                        @error('name') <span class="error-txt">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="username">Pen Name (Username)</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="@arundhati">
                        @error('username') <span class="error-txt">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="writer@example.com">
                    @error('email') <span class="error-txt">{{ $message }}</span> @enderror
                </div>

                <div class="grid-row">
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••">
                        @error('password') <span class="error-txt">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••">
                    </div>
                </div>

                <div class="input-group">
                    <label for="avatar">Author Portrait</label>
                    <input type="file" name="avatar" id="avatar" accept=".png,.jpg,.jpeg">
                    @error('avatar') <span class="error-txt">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="otp">Verification Code</label>
                    <div class="otp-wrapper">
                        <input type="text" name="otp" id="otp" placeholder="Enter the code sent to email">
                        
                        <button type="button" id="otpBtn" class="btn-otp" onclick="requestOtp()">Get OTP</button>
                    </div>
                    @error('otp') <span class="error-txt">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit">Publish Your Profile</button>
            </form>

            <div class="login-link">
                Already have an account? 
                <a href="{{ route('login.page') }}">Sign in</a>
            </div>
        </div>
    </main>

    <script>
        const url = "{{ config('app.url') }}";
        // 1. Function to send OTP (Initial State)
        function requestOtp() {
            let email = document.getElementById('email').value;
            let otpBtn = document.getElementById('otpBtn');

            if (!email) {
                alert("Please enter your email address first.");
                return;
            }

            // UI Feedback
            otpBtn.innerText = "Sending...";
            otpBtn.disabled = true;

            fetch(`${url}/api/public/get-otp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => res.json())
            .then(data => {
                // On Success: Change Button to "Verify" Mode
                alert(data.message || "OTP Sent to your email.");
                
                // Switch Button Visuals
                otpBtn.disabled = false;
                otpBtn.innerText = "Verify OTP"; 
                otpBtn.classList.add('verify-mode'); // Turns Green
                
                // Switch Button Logic
                // We remove the old onclick and set the new one
                otpBtn.removeAttribute('onclick');
                otpBtn.onclick = verifyAndSubmit; 
            })
            .catch(err => {
                console.error(err);
                alert("Error sending OTP. Please try again.");
                otpBtn.innerText = "Get OTP";
                otpBtn.disabled = false;
            });
        }

        // 2. Function to Verify and Submit (Your requested Logic)
        function verifyAndSubmit() {
            let email = document.querySelector('input[name="email"]').value;
            let otp = document.querySelector('input[name="otp"]').value;
            let otpBtn = document.getElementById('otpBtn');

            // Simple validation
            if (!otp) {
                alert("Please enter the OTP.");
                return;
            }

            otpBtn.innerText = "Verifying...";

            fetch(`${url}/api/public/verify-otp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email, otp: otp })
            })
            .then(res => res.json())
            .then(data => {
                if (data.message === 'OTP verified') {
                    // Success: Submit the whole form
                    otpBtn.innerText = "OTP verified";
                } else {
                    alert(data.message);
                    otpBtn.innerText = "Verify OTP"; // Reset text on failure
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred during verification.");
                otpBtn.innerText = "Verify OTP";
            });
        }
    </script>
</body>
</html>