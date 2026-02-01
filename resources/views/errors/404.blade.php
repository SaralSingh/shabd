<!DOCTYPE html>
<html>
<head>
    <title>404 - Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 100px;
        }

        h1 {
            font-size: 48px;
            color: #dc3545;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        a {
            margin-top: 20px;
            display: inline-block;
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    <p>Oops! The page you're looking for doesn't exist or you don't have access to it.</p>
    <a href="{{ route('home.page') }}">← Back to Home</a>
</body>
</html>
