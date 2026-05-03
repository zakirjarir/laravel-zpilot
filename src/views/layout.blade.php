<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Installer | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.1);
            --success: #10b981;
            --error: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .installer-container {
            width: 100%;
            max-width: 600px;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(to right, #6366f1, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            letter-spacing: -1px;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            padding: 0 10px;
        }

        /* ... existing steps styling ... */

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            border: 1px solid var(--border);
            flex: 0 0 auto;
            width: auto;
            padding: 14px 25px;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* ... footer styling ... */
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="header">
            <div class="logo">Z-laravel-installer</div>
            <div class="steps">
                <div class="step {{ Request::is('install') ? 'active' : 'completed' }}">1</div>
                <div class="step {{ Request::is('install/requirements') ? 'active' : (Request::is('install') ? '' : 'completed') }}">2</div>
                <div class="step {{ Request::is('install/environment') ? 'active' : (Request::is('install') || Request::is('install/requirements') ? '' : 'completed') }}">3</div>
                <div class="step {{ Request::is('install/database') ? 'active' : (Request::is('install/environment') ? '' : 'completed') }}">4</div>
                <div class="step {{ Request::is('install/finish') ? 'active' : '' }}">5</div>
            </div>
        </div>

        <div class="content">
            @if(session('message'))
                <div class="alert alert-error">
                    {{ session('message') }}
                </div>
            @endif

            @yield('content')
        </div>

        <div class="footer">
            Built with ❤️ by <a href="https://github.com/zakirjarir" target="_blank">zakirjarir</a>
        </div>
    </div>
</body>
</html>
