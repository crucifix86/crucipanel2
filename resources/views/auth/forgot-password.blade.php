<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('pw-config.server_name', 'Laravel') }} - {{ __('auth.form.forgotPassword') }}</title>
    <meta name="description" content="Password reset for {{ config('pw-config.server_name') }}">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/portal/bootstrap/dist/css/bootstrap.min.css') }}" />
    {{-- FontAwesome for icons --}}
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fontawesome-all.min.js') }}"></script>
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fa-v4-shims.min.js') }}"></script>
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom-home.css') }}">

    @php
        $userTheme = auth()->check() ? auth()->user()->theme : config('themes.default');
        $themeConfig = config('themes.themes.' . $userTheme);
    @endphp
    
    @if($themeConfig && isset($themeConfig['css']))
        <link rel="stylesheet" href="{{ asset($themeConfig['css']) }}">
    @endif

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        /* Modern Dark Theme Variables */
        :root {
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a3a;
            --bg-tertiary: #2a2a4a;
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: #334155;
            --card-bg: #1e293b;
            --hover-bg: rgba(99, 102, 241, 0.1);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.5);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-accent: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        /* Global Dark Theme */
        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Custom Navbar Styles */
        .custom-navbar {
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            padding: 12px 0;
            min-height: 70px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .custom-navbar .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-navbar .navbar-brand img {
            height: 40px;
            width: auto;
        }

        .custom-navbar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .custom-navbar .nav-link:hover, .custom-navbar .nav-link.active {
            color: #ffd700 !important;
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .custom-navbar .navbar-toggler {
            border-color: rgba(255,255,255,0.3);
            padding: 4px 8px;
        }

        .custom-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Form Styling */
        .auth-form-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
        }
        .auth-form-container h2 {
            color: var(--accent-primary);
            font-weight: 600;
            margin-bottom: 24px;
            text-align: center;
            font-size: 1.75rem;
        }
        .auth-form-container .form-control {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.3s ease;
            margin-bottom: 16px;
            width: 100%;
        }
        .auth-form-container .form-control::placeholder { color: var(--text-muted); }
        .auth-form-container .form-control:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
            background: var(--bg-tertiary);
        }
        .auth-form-container .btn-submit {
            background: var(--gradient-accent);
            border: none; color: white; padding: 14px 20px; border-radius: 10px;
            font-weight: 600; font-size: 15px; transition: all 0.3s ease;
            position: relative; overflow: hidden; width: 100%;
        }
        .auth-form-container .btn-submit::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .auth-form-container .btn-submit:hover::before { left: 100%; }
        .auth-form-container .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        .auth-form-container .auth-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        .auth-form-container .auth-links a {
            color: var(--accent-primary); text-decoration: none;
            transition: color 0.3s ease;
        }
        .auth-form-container .auth-links a:hover { color: var(--accent-secondary); }

        /* Validation errors styling */
        .validation-errors {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            color: #f87171;
        }
        .validation-errors ul {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }
        .validation-errors li {
            font-size: 14px;
        }
        .status-message {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.4);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            color: #4ade80;
            text-align: center;
            font-size: 14px;
        }

        /* Main Content Area */
        .custom-home-content-wrap {
            background: var(--bg-primary);
            min-height: calc(100vh - 140px);
            padding: 40px 0;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        /* Mobile responsiveness */
        @media (max-width: 991px) {
            .custom-navbar .navbar-nav { padding-top: 10px; }
            .custom-navbar .nav-link, .custom-navbar .nav-item .dropdown-toggle {
                margin: 2px 0; text-align: center;
            }
            .auth-form-container {
                margin-left: 15px;
                margin-right: 15px;
            }
        }
        .navbar-logo { height: 60px !important; width: auto; margin-right: 10px; }
        .navbar-badge { cursor: default; pointer-events: none; }
        
        /* Header Section */
        .site-header {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
            padding: 30px 0;
            text-align: center;
            border-bottom: 2px solid var(--accent-primary);
            box-shadow: var(--shadow-lg);
        }
        
        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .header-logo {
            max-height: 120px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.5));
            transition: transform 0.3s ease;
        }
        
        .header-logo:hover {
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            .site-header { padding: 20px 0; }
            .header-logo { max-height: 80px; }
        }

        .info-text {
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body class="theme-{{ $userTheme }}">
    {{-- Language Selector and Theme Toggle - Fixed Position, Top Right --}}
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1100; display: flex; align-items: center; gap: 10px;">
        @if(Auth::check())
            @livewire('theme-selector')
        @endif
        <x-home-theme-toggle />
        <x-hrace009::language-button />
    </div>

    {{-- Header Section --}}
    <header class="site-header">
        <div class="container-fluid">
            <div class="header-content">
                <img src="{{ asset('img/logo/haven_perfect_world_logo.svg') }}" alt="{{ config('pw-config.server_name') }}" class="header-logo" onclick="window.location.href='{{ route('HOME') }}'" style="cursor: pointer;">
            </div>
        </div>
    </header>

    {{-- Custom Navbar --}}
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <div class="navbar-brand">
                @if( !config('pw-config.logo') || config('pw-config.logo') === '' )
                    <img src="{{ asset('img/logo/logo.png') }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo navbar-badge">
                @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
                    <img src="{{ asset(config('pw-config.logo')) }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo navbar-badge">
                @else
                    <img src="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo navbar-badge">
                @endif
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    {{-- Home Link --}}
                    <a class="nav-link {{ Route::is('HOME') ? 'active' : '' }}" href="{{ route('HOME') }}">
                        <i class="fas fa-home me-1"></i>{{ __('general.home') }}
                    </a>

                    {{-- Shop Link --}}
                    @if( config('pw-config.system.apps.shop') )
                    <a class="nav-link {{ Route::is('app.shop.index') ? 'active' : '' }}" href="{{ route('app.shop.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>{{ __('shop.title') }}
                    </a>
                    @endif

                    {{-- Donate Link --}}
                    @if( config('pw-config.system.apps.donate') )
                    <a class="nav-link {{ Route::is('app.donate.history') ? 'active' : '' }}" href="{{ route('app.donate.history') }}">
                        <i class="fas fa-credit-card me-1"></i>{{ __('donate.title') }}
                    </a>
                    @endif

                    {{-- Voucher Link --}}
                    @if( config('pw-config.system.apps.voucher') )
                    <a class="nav-link {{ Route::is('app.voucher.index') ? 'active' : '' }}" href="{{ route('app.voucher.index') }}">
                        <i class="fas fa-ticket-alt me-1"></i>{{ __('voucher.title') }}
                    </a>
                    @endif

                    {{-- Ingame Service Link --}}
                    @if( config('pw-config.system.apps.inGameService') )
                    <a class="nav-link {{ Route::is('app.services.index') ? 'active' : '' }}" href="{{ route('app.services.index') }}">
                        <i class="fas fa-tools me-1"></i>{{ __('service.title') }}
                    </a>
                    @endif

                    {{-- Ranking Link --}}
                    @if( config('pw-config.system.apps.ranking') )
                    <a class="nav-link {{ Route::is('app.ranking.index') ? 'active' : '' }}" href="{{ route('app.ranking.index') }}">
                        <i class="fas fa-trophy me-1"></i>{{ __('ranking.title') }}
                    </a>
                    @endif

                    {{-- Vote Link --}}
                    @if( config('pw-config.system.apps.vote') )
                    <a class="nav-link {{ Route::is('app.vote.index') ? 'active' : '' }}" href="{{ route('app.vote.index') }}">
                        <i class="fas fa-vote-yea me-1"></i>{{ __('vote.title') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="custom-home-content-wrap">
        <div class="auth-form-container">
            <h2>{{ __('auth.form.forgotPassword') }}</h2>

            <div class="info-text">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            @if ($errors->any())
                <div class="validation-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           placeholder="{{ __('auth.form.email') }}" required autofocus/>
                </div>

                @if( config('pw-config.system.apps.captcha') )
                    <div class="mb-3">
                        @captcha
                        <input id="captcha" type="text" class="form-control mt-2" name="captcha" placeholder="{{ __('captcha.enter_code') }}" required>
                    </div>
                @endif

                <button type="submit" class="btn btn-submit">
                    {{ __('auth.form.sendLinkPassword') }}
                </button>

                <div class="auth-links text-center mt-3">
                    <a href="{{ route('login') }}">{{ __('Back to Login') }}</a>
                </div>

            </form>
        </div>
    </div>

    <x-hrace009::portal.footer />

    {{-- Scripts --}}
    <script src="{{ asset('vendor/portal/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/portal/jarallax/dist/jarallax.min.js') }}"></script>
    <script src="{{ asset('js/portal/portal.js') }}"></script>

    {{-- AlpineJS for dropdowns and other reactive components --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Livewire Scripts --}}
    @livewireScripts

</body>
</html>