<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $Subject ?? 'Welcome to Blogify' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        h1 {
            color: #4CAF50;
        }
        p {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>{{ $Subject ?? 'Welcome!' }}</h1>
        <p>{{ $Message ?? 'Thank you for joining Blogify. We\'re excited to have you on board!' }}</p>

        <p class="footer">
            &copy; {{ date('Y') }} Blogify. All rights reserved.
        </p>
    </div>
</body>
</html>
