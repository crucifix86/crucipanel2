<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description  }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="{{ $author  }}">

    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:url" content="{{ $og_url }}">
    <meta property="og:type" content="blog">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $og_image }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name='twitter:description' content="{{ $description }}">
    <meta name="twitter:url" content="{{ $og_url }}">
    <meta name="twitter:image" content="{{ $og_image }}">

    @if( ! config('pw-config.logo') )
        <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}"/>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/logo/logo.png') }}" />
    @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(config('pw-config.logo')) }}" />
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}" />
    @endif

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/portal/bootstrap/dist/css/bootstrap.min.css') }}" />
    {{-- FontAwesome for icons --}}
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fontawesome-all.min.js') }}"></script>
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fa-v4-shims.min.js') }}"></script>
    {{-- Original portal styles --}}
    <x-hrace009::portal.top-script/>
    {{-- Custom CSS from home page --}}
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
        /* Copy all the styles from home.blade.php */
        /* Light Theme Variables (Default) */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --hover-bg: rgba(99, 102, 241, 0.05);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-accent: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        
        /* Dark Theme Variables */
        body.dark-mode {
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

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Navbar Styles */
        .custom-navbar {
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            padding: 12px 0;
            min-height: 80px;
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
            height: 60px;
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

        /* Dropdown styles for Download/Guide sections */
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

        /* Account Dropdown Styling */
        .navbar .dropdown-menu {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            margin-top: 10px;
        }
        
        .navbar .dropdown-menu .dropdown-item {
            color: var(--text-primary);
        }
        
        .navbar .dropdown-menu .dropdown-item:hover {
            background: var(--hover-bg);
            color: var(--accent-primary);
        }

        /* Logo styling */
        .navbar-logo {
            height: 60px !important;
            width: auto;
            margin-right: 10px;
        }
        
        .navbar-badge {
            cursor: default;
            pointer-events: none;
        }
        
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

        /* Article content specific styles */
        .youplay-banner {
            background: var(--bg-secondary);
            padding: 60px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .youplay-banner h1 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 2.5rem;
            margin: 0;
        }

        .youplay-news {
            padding: 40px 0;
            background: var(--bg-primary);
        }

        .news-one {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
        }

        .news-one .tags {
            margin-bottom: 20px;
        }

        .news-one .tags a {
            color: var(--text-secondary);
            text-decoration: none;
            padding: 4px 12px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 8px;
        }

        .news-one .tags a:hover {
            background: var(--accent-primary);
            color: white;
            transform: translateY(-2px);
        }

        .news-one .meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .news-one .meta .item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .news-one .meta-icon {
            color: var(--accent-primary);
        }

        .news-one .description {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .social-list {
            margin-top: 30px;
        }

        .social-list .btn {
            margin-right: 10px;
            padding: 8px 16px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .social-list .btn:hover {
            background: var(--accent-primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Mobile responsiveness */
        @media (max-width: 991px) {
            .custom-navbar .navbar-nav {
                padding-top: 10px;
            }

            .custom-navbar .nav-link, .custom-navbar .nav-item .dropdown-toggle {
                margin: 2px 0;
                text-align: center;
            }

            .site-header {
                padding: 20px 0;
            }
            
            .header-logo {
                max-height: 80px;
            }
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
                    <a class="nav-link" href="{{ route('HOME') }}">
                        <i class="fas fa-home me-1"></i>{{ __('general.home') }}
                    </a>

                    {{-- Shop Link --}}
                    @if( config('pw-config.system.apps.shop') )
                    <a class="nav-link" href="{{ route('app.shop.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>{{ __('shop.title') }}
                    </a>
                    @endif

                    {{-- Donate Link --}}
                    @if( config('pw-config.system.apps.donate') )
                    <a class="nav-link" href="{{ route('app.donate.history') }}">
                        <i class="fas fa-credit-card me-1"></i>{{ __('donate.title') }}
                    </a>
                    @endif

                    {{-- Voucher Link --}}
                    @if( config('pw-config.system.apps.voucher') )
                    <a class="nav-link" href="{{ route('app.voucher.index') }}">
                        <i class="fas fa-ticket-alt me-1"></i>{{ __('voucher.title') }}
                    </a>
                    @endif

                    {{-- Ingame Service Link --}}
                    @if( config('pw-config.system.apps.inGameService') )
                    <a class="nav-link" href="{{ route('app.services.index') }}">
                        <i class="fas fa-tools me-1"></i>{{ __('service.title') }}
                    </a>
                    @endif

                    {{-- Ranking Link --}}
                    @if( config('pw-config.system.apps.ranking') )
                    <a class="nav-link" href="{{ route('app.ranking.index') }}">
                        <i class="fas fa-trophy me-1"></i>{{ __('ranking.title') }}
                    </a>
                    @endif

                    {{-- Vote Link --}}
                    @if( config('pw-config.system.apps.vote') )
                    <a class="nav-link" href="{{ route('app.vote.index') }}">
                        <i class="fas fa-vote-yea me-1"></i>{{ __('vote.title') }}
                    </a>
                    @endif

                    {{-- Download Links --}}
                    @isset($download)
                        @if( $download->exists() && $download->count() > 0 )
                            @if( $download->count() === 1 )
                                <a class="nav-link" href="{{ route('show.article', $download->first()->slug ) }}">
                                    <i class="fas fa-download me-1"></i>{{ $download->first()->title }}
                                </a>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="downloadDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-download me-1"></i>{{ __('news.category.download') }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                        @foreach( $download->get() as $page )
                                            <li><a class="dropdown-item" href="{{ route('show.article', $page->slug ) }}">{{ $page->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endisset

                    {{-- Guide Links --}}
                    @isset($guide)
                        @if( $guide->exists() && $guide->count() > 0 )
                            @if( $guide->count() === 1 )
                                <a class="nav-link" href="{{ route('show.article', $guide->first()->slug ) }}">
                                    <i class="fas fa-book-open me-1"></i>{{ $guide->first()->title }}
                                </a>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="guideDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-book-open me-1"></i>{{ __('news.category.guide') }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="guideDropdown">
                                        @foreach( $guide->get() as $guidepage )
                                            <li><a class="dropdown-item" href="{{ route('show.article', $guidepage->slug ) }}">{{ $guidepage->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endisset
                </div>

                <div class="navbar-nav">
                    @if(Auth::check())
                        {{-- If user is logged in --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
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
                                <div class="d-grid gap-2">
                                    <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-user me-1"></i>{{ __('general.dashboard.profile.header') }}
                                    </a>
                                    <a href="{{ route('app.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-tachometer-alt me-1"></i>{{ __('general.menu.dashboard') }}
                                    </a>
                                    <a href="{{ route('app.donate.history') }}" class="btn btn-sm btn-outline-info">
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
            </div>
        </div>
    </nav>

    {{-- Article Content --}}
    <div class="content-wrap">
        <section class="youplay-banner banner-top youplay-banner-parallax small">
            <div class="info">
                <div>
                    <div class="container">
                        <h1 class="h1">{{ $article_title }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="container youplay-news">
            {{-- News Article --}}
            <div class="col-md-9">
                <article class="news-one">
                    <div class="tags">
                        @php($tags = explode(',', $keywords ))
                        <i class="fa fa-tags"></i>
                        @foreach( $tags as $tag )
                            <a href="{{ route('show.article.tag', $tag) }}">{{ $tag }}</a>{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </div>
                    <div class="meta">
                        <div class="item">
                            <i class="fa fa-user meta-icon"></i>
                            {{ $author  }}
                        </div>
                        <div class="item">
                            <i class="fa fa-calendar meta-icon"></i>
                            {{ __('news.published') . ' ' .$published }}
                        </div>
                        <div class="item">
                            <i class="fa fa-bookmark meta-icon"></i>
                            {{ $categories }}
                        </div>
                    </div>
                    <div class="description">
                        {{ $news }}
                    </div>
                    {{-- Post Share --}}
                    <div class="btn-group social-list social-likes" data-url="{{ $og_url }}" data-counters="no">
                        <span class="btn btn-default facebook" title="Share link on Facebook"></span>
                        <span class="btn btn-default twitter" title="Share link on Twitter"></span>
                    </div>
                </article>
            </div>

            {{-- Right Side --}}
            <div class="col-md-3">
                {{ $widget }}
            </div>
        </div>

        <x-hrace009::portal.footer/>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('vendor/portal/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/portal/jarallax/dist/jarallax.min.js') }}"></script>
    <script src="{{ asset('js/portal/portal.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <x-hrace009::portal.bottom-script/>

    {{-- Livewire Scripts --}}
    @livewireScripts

</body>
</html>