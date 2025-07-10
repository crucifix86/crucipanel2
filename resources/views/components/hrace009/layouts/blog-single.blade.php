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
        .article-hero {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
            padding: 80px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-bottom: 2px solid var(--accent-primary);
        }

        .article-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .article-hero h1 {
            color: var(--text-primary);
            font-weight: 800;
            font-size: 3rem;
            margin: 0 0 20px;
            position: relative;
            z-index: 1;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .article-hero-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .article-hero-meta .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-size: 1rem;
            font-weight: 500;
        }

        .article-hero-meta .meta-item i {
            color: var(--accent-primary);
            font-size: 1.1rem;
        }

        .youplay-news {
            padding: 60px 0;
            background: var(--bg-primary);
        }

        .article-content {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 0;
            box-shadow: var(--shadow-lg);
            margin-bottom: 30px;
            overflow: hidden;
            position: relative;
        }

        .article-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
        }

        .article-body {
            padding: 40px;
        }

        .article-tags {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .article-tags .tags-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .article-tags .tag-icon {
            color: var(--accent-primary);
            font-size: 1.2rem;
        }

        .article-tags a {
            display: inline-flex;
            align-items: center;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 30px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .article-tags a:hover {
            background: var(--accent-primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .article-text {
            color: var(--text-secondary);
            line-height: 1.9;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .article-text p {
            margin-bottom: 1.5rem;
        }

        .article-text h2, .article-text h3 {
            color: var(--text-primary);
            margin: 2rem 0 1rem;
            font-weight: 700;
        }

        .article-text h2 {
            font-size: 1.8rem;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-primary);
        }

        .article-text h3 {
            font-size: 1.4rem;
        }

        .article-text blockquote {
            border-left: 4px solid var(--accent-primary);
            padding-left: 20px;
            margin: 20px 0;
            font-style: italic;
            color: var(--text-muted);
        }

        .article-text a {
            color: var(--accent-primary);
            text-decoration: none;
            border-bottom: 1px dotted var(--accent-primary);
            transition: all 0.3s ease;
        }

        .article-text a:hover {
            color: var(--accent-secondary);
            border-bottom-style: solid;
        }

        .article-text ul, .article-text ol {
            margin-bottom: 1.5rem;
            padding-left: 30px;
        }

        .article-text li {
            margin-bottom: 0.5rem;
        }

        .article-text code {
            background: var(--bg-secondary);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
            color: var(--accent-primary);
        }

        .article-text pre {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            overflow-x: auto;
            margin: 20px 0;
        }

        .article-text pre code {
            background: none;
            padding: 0;
            color: var(--text-primary);
        }

        .article-text img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: var(--shadow-md);
        }

        .article-footer {
            padding: 30px 40px;
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
        }

        .social-share {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .social-share-label {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .social-share-buttons {
            display: flex;
            gap: 12px;
        }

        .social-share-buttons .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--bg-tertiary);
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-share-buttons .share-btn:hover {
            transform: translateY(-3px) scale(1.1);
            border-color: var(--accent-primary);
            color: var(--accent-primary);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .social-share-buttons .facebook:hover {
            background: #1877f2;
            color: white;
            border-color: #1877f2;
        }

        .social-share-buttons .twitter:hover {
            background: #1da1f2;
            color: white;
            border-color: #1da1f2;
        }

        @media (max-width: 768px) {
            .article-hero h1 {
                font-size: 2rem;
            }

            .article-body {
                padding: 25px;
            }

            .article-hero-meta {
                gap: 15px;
            }
        }

        /* Main Content Area */
        .main-content-area {
            float: left;
            width: 70%;
            padding-right: 30px;
            box-sizing: border-box;
        }

        .sidebar-area {
            float: right;
            width: 30%;
            margin-left: 30px;
            box-sizing: border-box;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 28px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }

        /* Clearfix for container */
        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Widget Styling for Dark Theme */
        .sidebar-area .side-block {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-md);
        }

        .sidebar-area .side-block .block-title {
            color: var(--text-primary);
            font-size: 1.25rem;
            font-weight: 600;
            padding-bottom: 10px;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--accent-secondary);
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-area .side-block .block-content {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .sidebar-area .side-block .block-content:last-child {
            margin-bottom: 0;
        }

        .sidebar-area .side-block .block-content .label,
        .sidebar-area .side-block .block-content .badge {
            background-color: var(--accent-primary) !important;
            color: white !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.9rem;
        }

        .sidebar-area .side-block .block-content .bg-success {
            background-color: #28a745 !important;
        }
        .sidebar-area .side-block .block-content .bg-danger {
            background-color: #dc3545 !important;
        }

        /* GM List Table */
        .sidebar-area .table-gmlist {
            width: 100%;
            color: var(--text-secondary);
        }
        .sidebar-area .table-gmlist td {
            padding: 8px 4px;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
        }
        .sidebar-area .table-gmlist tr:first-child td {
            border-top: none;
        }
        .sidebar-area .table-gmlist img.img-rounded {
            border-radius: 50%;
            border: 2px solid var(--border-color);
        }

        /* News Category Links in Widget */
        .sidebar-area .side-block ul.block-content {
            list-style: none;
            padding-left: 0;
        }
        .sidebar-area .side-block ul.block-content a {
            display: block;
            color: var(--accent-secondary);
            text-decoration: none;
            padding: 6px 0;
            border-bottom: 1px dashed var(--border-color);
            transition: color 0.3s ease, padding-left 0.3s ease;
        }
        .sidebar-area .side-block ul.block-content a:hover {
            color: var(--accent-primary);
            padding-left: 5px;
        }
        .sidebar-area .side-block ul.block-content a:last-child {
            border-bottom: none;
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

            .main-content-area,
            .sidebar-area {
                float: none;
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }

            .sidebar-area {
                margin-top: 30px;
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
        {{-- Article Hero Section --}}
        <section class="article-hero">
            <div class="container">
                <h1>{{ $article_title }}</h1>
                <div class="article-hero-meta">
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $author }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $published }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-folder"></i>
                        {{ $categories }}
                    </div>
                </div>
            </div>
        </section>

        <div class="container youplay-news" style="display: flow-root;">
            {{-- News Article --}}
            <div class="main-content-area">
                <article class="article-content">
                    <div class="article-body">
                        <div class="article-tags">
                            <div class="tags-container">
                                <i class="fas fa-tags tag-icon"></i>
                                @php($tags = explode(',', $keywords ))
                                @foreach( $tags as $tag )
                                    <a href="{{ route('show.article.tag', trim($tag)) }}">{{ trim($tag) }}</a>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="article-text">
                            {!! $news !!}
                        </div>
                    </div>
                    
                    {{-- Article Footer with Share --}}
                    <div class="article-footer">
                        <div class="social-share">
                            <span class="social-share-label">Share this article:</span>
                            <div class="social-share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($og_url) }}" 
                                   target="_blank" 
                                   class="share-btn facebook"
                                   title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($og_url) }}&text={{ urlencode($article_title) }}" 
                                   target="_blank" 
                                   class="share-btn twitter"
                                   title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Right Side --}}
            <aside class="sidebar-area">
                {{ $widget }}
            </aside>
        </div>

        <x-hrace009::portal.footer/>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('vendor/portal/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/portal/jarallax/dist/jarallax.min.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Livewire Scripts --}}
    @livewireScripts

</body>
</html>