<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts - Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead
    @php
        $isHome = request()->is('/');
        $showHomeAction = !$isHome;
    @endphp

    <style>
        #boot-fallback {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        #boot-fallback .fallback-card {
            width: min(100%, 420px);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 24px;
            padding: 28px;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            text-align: center;
        }

        #boot-fallback .fallback-logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            border-radius: 18px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #boot-fallback h1 {
            margin: 0 0 8px;
            color: #0f172a;
            font-size: 28px;
            font-weight: 800;
        }

        #boot-fallback p {
            margin: 0;
            color: #475569;
            line-height: 1.6;
        }

        #boot-fallback .fallback-actions {
            display: grid;
            gap: 12px;
            margin-top: 24px;
        }

        #boot-fallback .fallback-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 16px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }

        #boot-fallback .fallback-button:hover {
            opacity: 0.92;
        }

        #boot-fallback .fallback-button.primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #fff;
        }

        #boot-fallback .fallback-button.secondary {
            border: 1px solid #cbd5e1;
            color: #0f172a;
            background: #fff;
        }

        body.boot-fallback-visible #boot-fallback {
            opacity: 1;
            pointer-events: auto;
        }

        body.app-ready #boot-fallback {
            display: none !important;
        }

        body.dark {
            background-color: rgb(2 6 23);
        }

        body.light {
            background-color: rgb(248 250 252);
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 transition-colors duration-200" onload="setInitialTheme()">

    <div id="boot-fallback">
        <div class="fallback-card">
            <div class="fallback-logo">O</div>
            <h1>{{ request()->getHost() }}</h1>
            <p>
                Halaman tidak berhasil dimuat sepenuhnya. Gunakan tombol di bawah untuk kembali
                ke beranda atau buka halaman yang dibutuhkan.
            </p>
            <div class="fallback-actions">
                @if ($showHomeAction)
                    <a href="{{ url('/') }}" class="fallback-button primary">Kembali ke Beranda</a>
                @elseif (Route::has('login'))
                    <a href="{{ route('login') }}" class="fallback-button primary">Masuk</a>
                @endif

                @if ($isHome && Route::has('register'))
                    <a href="{{ route('register') }}" class="fallback-button secondary">Daftar</a>
                @endif

                @if ($showHomeAction && Route::has('login') && !request()->is('login'))
                    <a href="{{ route('login') }}" class="fallback-button secondary">Masuk</a>
                @endif

                @if ($showHomeAction && Route::has('register') && !request()->is('register'))
                    <a href="{{ route('register') }}" class="fallback-button secondary">Daftar</a>
                @endif

                <a href="{{ url()->current() }}" class="fallback-button secondary">Muat Ulang</a>
            </div>
        </div>
    </div>

    @inertia
    <script>
        function setInitialTheme() {
            try {
                const darkMode = localStorage.getItem('darkMode') === 'true';
                if (darkMode) {
                    document.body.classList.add('dark');
                    document.body.classList.remove('light');
                } else {
                    document.body.classList.add('light');
                    document.body.classList.remove('dark');
                }
            } catch (error) {
                document.body.classList.add('light');
                document.body.classList.remove('dark');
            }
        }

        window.__bootFallbackTimer = window.setTimeout(function() {
            if (!document.body.classList.contains('app-ready')) {
                document.body.classList.add('boot-fallback-visible');
            }
        }, 5000);
    </script>
</body>

</html>
