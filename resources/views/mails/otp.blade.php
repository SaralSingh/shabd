<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $Subject }}</title>
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .otp-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .otp-container h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .otp-container p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 48px;
            letter-spacing: 10px;
            font-weight: bold;
            color: #ffd700;
            background-color: rgba(0, 0, 0, 0.2);
            padding: 10px 20px;
            border-radius: 12px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h1>{{ $Subject }}</h1>
    <p>{{ $Message }}</p>
    <div class="otp-code">{{ $OTP }}</div>
</div>

</body>
</html>
