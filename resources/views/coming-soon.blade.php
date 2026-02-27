<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ \App\Models\Setting::get('site_name', config('app.name')) }} – Coming Soon</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|source-sans-pro:400,600&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 50%, #0c0f1a 100%);
            color: #f8fafc;
            padding: 2rem;
            text-align: center;
        }
        .container { max-width: 520px; }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #fbbf24;
            margin-bottom: 2.5rem;
            letter-spacing: 0.02em;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.02em;
        }
        p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.7;
            margin-bottom: 2rem;
        }
        .spacer { height: 1rem; }
        .line {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b);
            margin: 0 auto 2rem;
            border-radius: 2px;
        }
        a.login {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e3a5f;
            background: #fbbf24;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
        }
        a.login:hover {
            background: #f59e0b;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</div>
        <div class="line"></div>
        <h1>Coming Soon</h1>
        <p>We're putting the finishing touches on an amazing experience. Check back soon.</p>
        <a href="{{ url(config('app.filament_admin_path', 'backend')) }}" class="login">Admin Login</a>
    </div>
</body>
</html>
