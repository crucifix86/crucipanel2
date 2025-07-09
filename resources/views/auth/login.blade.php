<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('pw-config.server_name', 'Laravel') }} - {{ __('auth.form.login') }}</title>
    <meta name="description" content="User login for {{ config('pw-config.server_name') }}">

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

        /* Dropdown styles */
        .custom-navbar .dropdown-menu {
            background-color: #6a5acd;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-radius: 8px;
            padding: 10px 0;
        }
        .custom-navbar .dropdown-menu .dropdown-item {
            color: rgba(255,255,255,0.85) !important;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .custom-navbar .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: #ffd700 !important;
        }
        .custom-navbar .dropdown-toggle::after {
            color: rgba(255,255,255,0.9);
        }

        /* Login/Account Link Styling */
        .login-hover-reveal { position: relative; }
        .account-link {
            display: flex; align-items: center; gap: 10px; padding: 10px 18px;
            border-radius: 8px; transition: all 0.3s ease; color: var(--text-secondary) !important;
            text-decoration: none; position: relative; overflow: hidden;
        }
        .account-link::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: var(--gradient-accent); opacity: 0; transition: opacity 0.3s ease; z-index: -1;
        }
        .account-link:hover::before { opacity: 0.15; }
        .account-link:hover { color: var(--text-primary) !important; transform: translateY(-2px); box-shadow: var(--shadow-md); }

        /* Login/User Dropdown Content */
        .login-hover-content {
            position: absolute; top: calc(100% + 15px); right: 0; background: var(--card-bg);
            border: 1px solid var(--border-color); border-radius: 16px; box-shadow: var(--shadow-lg);
            padding: 28px; min-width: 320px; opacity: 0; visibility: hidden;
            transform: translateY(-15px) scale(0.95);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 1050;
        }
        .login-hover-content::before { /* Arrow */
            content: ''; position: absolute; top: -8px; right: 24px; width: 16px; height: 16px;
            background: var(--card-bg); border: 1px solid var(--border-color);
            border-right: none; border-bottom: none; transform: rotate(45deg);
        }
        .login-hover-reveal:hover .login-hover-content, .login-hover-content:hover {
            opacity: 1; visibility: visible; transform: translateY(0) scale(1);
        }

        /* Form Styling (adapted from home.blade.php login form) */
        .auth-form-container {
            max-width: 500px; /* Or desired width */
            margin: 40px auto; /* Centering with space */
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
            font-size: 1.75rem; /* Slightly larger title for the page */
        }
        .auth-form-container .form-control {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.3s ease;
            margin-bottom: 16px; /* Spacing between fields */
            width: 100%; /* Ensure full width */
        }
        .auth-form-container .form-control::placeholder { color: var(--text-muted); }
        .auth-form-container .form-control:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
            background: var(--bg-tertiary);
        }
        .auth-form-container .btn-submit { /* General submit button */
            background: var(--gradient-accent);
            border: none; color: white; padding: 14px 20px; border-radius: 10px;
            font-weight: 600; font-size: 15px; transition: all 0.3s ease;
            position: relative; overflow: hidden; width: 100%;
        }
        .auth-form-container .btn-submit::before { /* Shimmer effect */
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .auth-form-container .btn-submit:hover::before { left: 100%; }
        .auth-form-container .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        .auth-form-container .form-check-input {
            background-color: var(--bg-secondary); border-color: var(--border-color);
        }
        .auth-form-container .form-check-input:checked {
            background-color: var(--accent-primary); border-color: var(--accent-primary);
        }
        .auth-form-container .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }
        .auth-form-container .form-check-label { color: var(--text-secondary); }
        .auth-form-container .auth-links { /* For register and forgot password links */
            margin-top: 20px;
            display: flex;
            justify-content: space-between; /* Align items on opposite ends */
            font-size: 14px;
        }
        .auth-form-container .auth-links a {
            color: var(--accent-primary); text-decoration: none;
            transition: color 0.3s ease;
        }
        .auth-form-container .auth-links a:hover { color: var(--accent-secondary); }
        .auth-form-container .remember-me-forgot-password-wrapper { /* New wrapper for remember me and forgot password */
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem; /* space-y-6 is roughly 1.5rem */
        }


        /* Validation errors styling */
        .validation-errors {
            background-color: rgba(239, 68, 68, 0.1); /* Light red background */
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            color: #f87171; /* Red text for errors */
        }
        .validation-errors ul {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }
        .validation-errors li {
            font-size: 14px;
        }
        .status-message { /* For session status messages */
            background-color: rgba(34, 197, 94, 0.1); /* Light green background */
            border: 1px solid rgba(34, 197, 94, 0.4);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            color: #4ade80; /* Green text */
            text-align: center;
            font-size: 14px;
        }


        /* Main Content Area - Minimal for auth pages */
        .custom-home-content-wrap {
            background: var(--bg-primary);
            min-height: calc(100vh - 140px); /* Adjust based on navbar and footer height */
            padding: 40px 0;
            display: flex; /* For centering the form container */
            align-items: flex-start; /* Align to top, padding will handle spacing */
            justify-content: center;
        }

        /* Mobile responsiveness */
        @media (max-width: 991px) {
            .login-hover-content {
                position: static; opacity: 1; visibility: visible; transform: none;
                margin-top: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            .login-hover-content::before { display: none; }
            .custom-navbar .navbar-nav { padding-top: 10px; }
            .custom-navbar .nav-link, .custom-navbar .nav-item .dropdown-toggle {
                margin: 2px 0; text-align: center;
            }
             .auth-form-container {
                margin-left: 15px;
                margin-right: 15px;
            }
        }
        .navbar-logo { height: 35px; width: auto; margin-right: 8px; }

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

    {{-- Custom Navbar (copied from home.blade.php/register.blade.php) --}}
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('HOME') }}">
                @if( !config('pw-config.logo') || config('pw-config.logo') === '' )
                    <img src="{{ asset('img/logo/logo.png') }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo">
                @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
                    <img src="{{ asset(config('pw-config.logo')) }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo">
                @else
                    <img src="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo">
                @endif
                {{ config('pw-config.server_name', 'PW Panel') }}
            </a>
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
                <div class="navbar-nav">
                    @if(Auth::check())
                        {{-- If user is logged in --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                {{-- Use truename if available, fallback to name --}}
                                <span>{{ Auth::user()->truename ?? Auth::user()->name ?? 'User' }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown" style="min-width: 280px; padding: 20px;">
                                <div class="text-center mb-3">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_url)
                                        <img class="img-fluid rounded-circle mb-2" width="64" height="64" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->truename ?? Auth::user()->name }}" />
                                    @else
                                        <i class="fas fa-user-circle" style="font-size: 2.5rem; color: #667eea;"></i>
                                    @endif
                                    <h6 class="mt-2 mb-0">{{ Auth::user()->truename ?? Auth::user()->name ?? 'User' }}</h6>
                                    <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                                </div>
                                <hr>
                                <div class="d-grid gap-2"> {{-- Increased gap slightly --}}
                                    <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary"> {{-- Original used profile.show --}}
                                        <i class="fas fa-user me-1"></i>{{ __('general.dashboard.profile.header') }}
                                    </a>
                                    <a href="{{ route('app.dashboard') }}" class="btn btn-sm btn-outline-secondary"> {{-- Original dashboard link --}}
                                        <i class="fas fa-tachometer-alt me-1"></i>{{ __('general.menu.dashboard') }}
                                    </a>
                                    <a href="{{ route('app.donate.history') }}" class="btn btn-sm btn-outline-info"> {{-- Original donate history link --}}
                                        <i class="fas fa-history me-1"></i>{{ __('general.menu.donate.history') }}
                                    </a>
                                    @if(Auth::user()->isAdministrator())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-user-shield me-1"></i>Admin Dashboard
                                    </a>
                                    @endif
                                    @if(Auth::user()->isGamemaster())
                                    <a href="{{ route('gm.dashboard') }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-gamepad me-1"></i>GM Dashboard
                                    </a>
                                    @endif
                                    <hr class="my-2">
                                    <form method="POST" action="{{ route('logout') }}" class="d-grid">
                                        @csrf
                                        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-sign-out-alt me-1"></i>{{ __('general.logout') }}
                                        </a>
                                    </form>
                                </div>
                            </ul>
                        </li>
                    @else
                        {{-- If user is not logged in --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i>
                                <span>Account</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown" style="min-width: 320px; padding: 20px;">
                                <div class="login-form">
                                    <h5 class="text-center mb-3" style="color: #667eea;">
                                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('auth.form.login') }}
                                    </h5>

                                    {{-- Login form adapted from original navbar --}}
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name-login" class="form-label visually-hidden">{{ __('auth.form.login') }}:</label>
                                            <input id="name-login" type="text" name="name" class="form-control" placeholder="{{ __('auth.form.login_placeholder') ?? 'Username or Email' }}" required autofocus />
                                        </div>

                                        <div class="mb-3">
                                            <label for="password-login" class="form-label visually-hidden">{{ __('auth.form.password') }}:</label>
                                            <input id="password-login" type="password" name="password" class="form-control" placeholder="{{ __('auth.form.password') }}" required />
                                        </div>

                                        @if (! Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                                            <div class="mb-3">
                                                <label for="pin-login" class="form-label visually-hidden">{{ __('auth.form.pin') }}:</label>
                                                <input id="pin-login" type="password" name="pin" class="form-control" placeholder="{{ __('auth.form.pin') }}" required autocomplete="current-pin" />
                                            </div>
                                        @endif

                                        @if( config('pw-config.system.apps.captcha') )
                                            @captcha
                                            <div class="mb-3">
                                                <label for="captcha-login" class="form-label visually-hidden">{{ __('captcha.enter_code') }}:</label>
                                                <input id="captcha-login" type="text" name="captcha" class="form-control" placeholder="{{ __('captcha.enter_code') }}" required />
                                            </div>
                                        @endif

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" name="remember" class="form-check-input" id="remember_me_custom">
                                            <label class="form-check-label" for="remember_me_custom" style="font-size: 14px;">
                                                {{ __('auth.form.remember') }}
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-login w-100 mb-2">
                                            <i class="fas fa-sign-in-alt me-1"></i>{{ __('auth.form.login') }}
                                        </button>
                                    </form>

                                    <div class="login-divider">────── {{ __('general.or') }} ──────</div>

                                    <a href="{{ route('register') }}" class="btn btn-register w-100 mb-2">
                                        <i class="fas fa-user-plus me-1"></i>{{ __('auth.form.register') }}
                                    </a>

                                    <div class="text-center">
                                        <a href="{{ route('password.request') }}">{{ __('auth.form.forgotPassword') }}</a>
                                    </div>
                                </div>
                            </ul>
                        </li>
                    @endif
                </div>
            </div> {{-- End .collapse .navbar-collapse --}}

        </div> {{-- End .container-fluid --}}
    </nav>

    <div class="custom-home-content-wrap">
        <div class="auth-form-container">
            <h2>{{ __('auth.form.login') }}</h2>

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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                           placeholder="{{ __('auth.form.login_placeholder') ?? __('auth.form.login') }}" required autofocus autocomplete="name"/>
                </div>

                <div class="mb-3">
                    <input id="password" type="password" class="form-control" name="password"
                           placeholder="{{ __('auth.form.password') }}" required autocomplete="current-password"/>
                </div>

                @if (! Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                    <div class="mb-3">
                        <input id="pin" type="password" class="form-control" name="pin"
                               placeholder="{{ __('auth.form.pin') }}" required autocomplete="current-pin"/>
                    </div>
                @endif

                @if( config('pw-config.system.apps.captcha') )
                    <div class="mb-3">
                        @captcha
                        <input id="captcha" type="text" class="form-control mt-2" name="captcha" placeholder="{{ __('captcha.enter_code') }}" required>
                    </div>
                @endif

                <div class="remember-me-forgot-password-wrapper">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('auth.form.remember') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('auth.form.forgotPassword') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-submit">
                    {{ __('auth.form.login') }}
                </button>

                <div class="auth-links text-center mt-3"> {{-- Centered register link --}}
                    {{__('auth.form.noAccount')}} <a href="{{ route('register') }}">{{ __('auth.form.register') }}</a>
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
