<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel ZPilot | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #a855f7;
            --bg: #0b0f1a;
            --card-bg: rgba(17, 24, 39, 0.8);
            --text: #f3f4f6;
            --text-muted: #9ca3af;
            --border: rgba(255, 255, 255, 0.08);
            --success: #10b981;
            --error: #ef4444;
            --glass: rgba(255, 255, 255, 0.03);
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
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(168, 85, 247, 0.15) 0%, transparent 40%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.5;
        }

        .zpilot-container {
            width: 100%;
            max-width: 650px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            text-align: center;
            margin-bottom: 45px;
        }

        .logo {
            font-size: 2.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
            letter-spacing: -1.5px;
        }

        .steps-container {
            position: relative;
            margin-bottom: 40px;
            padding: 0 15px;
        }

        .steps-line {
            position: absolute;
            top: 18px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: var(--border);
            z-index: 1;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .step {
            width: 36px;
            height: 36px;
            background: var(--bg);
            border: 2px solid var(--border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-muted);
        }

        .step.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }

        .step.completed {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
        }

        .content {
            margin-bottom: 35px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
            letter-spacing: -0.5px;
        }

        p {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }

        input, select, textarea {
            width: 100%;
            background: var(--glass);
            border: 1px solid var(--border);
            padding: 14px 18px;
            border-radius: 14px;
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 16px 24px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: 16px;
            text-align: center;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -8px rgba(99, 102, 241, 0.5);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-back {
            flex: 0 0 auto;
            width: auto;
            padding: 14px 25px;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .alert {
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 30px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #ff4d4d;
            border: 1px solid rgba(239, 68, 68, 0.4);
            box-shadow: 0 10px 30px -10px rgba(239, 68, 68, 0.3);
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
            box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.3);
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(11, 15, 26, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 20px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--border);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .loading-text {
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        body.is-loading { pointer-events: none; }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text">Processing, please wait...</div>
    </div>

    <div class="zpilot-container">
        <div class="header">
            <div class="logo">Laravel ZPilot</div>
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
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            @yield('content')
        </div>

        <div class="footer">
            Developed by <a href="https://github.com/zakirjarir" target="_blank">Zakir Jarir</a>
            &bull; &copy; {{ date('Y') }}
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const overlay = document.getElementById('loadingOverlay');
            
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    overlay.style.display = 'flex';
                    document.body.classList.add('is-loading');
                    
                    const buttons = form.querySelectorAll('button, .btn');
                    buttons.forEach(btn => {
                        if(btn.tagName === 'BUTTON') btn.disabled = true;
                        btn.style.opacity = '0.7';
                        btn.style.cursor = 'not-allowed';
                    });
                });
            });
        });
    </script>
</body>
</html>
