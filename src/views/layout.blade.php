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
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(to right, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border);
            z-index: 1;
        }

        .step {
            width: 32px;
            height: 32px;
            background: var(--bg);
            border: 2px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .step.active {
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
        }

        .step.completed {
            background: var(--success);
            border-color: var(--success);
        }

        .content {
            margin-bottom: 30px;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #fff;
        }

        p {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        input, select {
            width: 100%;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border);
            padding: 12px 16px;
            border-radius: 12px;
            color: #fff;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: var(--primary);
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="header">
            <div class="logo">Laravel Installer</div>
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
