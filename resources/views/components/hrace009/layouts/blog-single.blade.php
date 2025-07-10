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
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('img/logo/logo.png') }}"
        />
    @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset(config('pw-config.logo')) }}"
        />
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"
        />
    @endif
    <x-hrace009::portal.top-script/>
    
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

        .custom-navbar .navbar-brand img,
        .navbar-logo {
            height: 60px !important;
            width: auto !important;
            max-width: none !important;
        }

        .navbar-badge {
            height: 60px !important;
            width: auto !important;
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
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            border-radius: 8px;
            padding: 10px 0;
        }
        
        .custom-navbar .dropdown-menu .dropdown-item {
            color: var(--text-primary) !important;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .custom-navbar .dropdown-menu .dropdown-item:hover {
            background-color: var(--hover-bg);
            color: var(--accent-primary) !important;
        }
    </style>
</head>


<body class="theme-{{ $userTheme }}">

<x-hrace009::portal.preload/>

{{-- Custom Navbar with Working Hover Login --}}
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
                                    @foreach( $guide->get() as $page )
                                        <li><a class="dropdown-item" href="{{ route('show.article', $page->slug ) }}">{{ $page->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                @endisset
            </div>

            {{-- Right side items --}}
            <div class="navbar-nav">
                {{-- Theme Selector --}}
                @livewire('theme-selector-widget')

                {{-- Language Button --}}
                @livewire('language-flag')

                {{-- Login/Logout --}}
                @guest
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>{{ __('general.login') }}
                    </a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>{{ __('general.register') }}
                        </a>
                    @endif
                @else
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->truename ?? Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('app.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>{{ __('general.acc_settings') }}
                            </a></li>
                            @if(Auth::user()->isAdministrator())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-2"></i>{{ __('general.admin_panel') }}
                                </a></li>
                            @endif
                            @if(Auth::user()->isGamemaster())
                                <li><a class="dropdown-item" href="{{ route('gm.dashboard') }}">
                                    <i class="fas fa-shield-alt me-2"></i>{{ __('general.gm_panel') }}
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('general.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{-- Header Section --}}
<div class="container-fluid text-center py-3">
    <div style="display: inline-block; cursor: pointer; width: 120px; height: auto;" onclick="window.location.href='{{ route('HOME') }}'">
        <img src="{{ asset(config('pw-config.header_logo', 'img/logo/haven_perfect_world_logo.svg')) }}" 
             alt="Header Logo" 
             style="width: 100%; height: auto; object-fit: contain;">
    </div>
</div>

<div class="content-wrap">

    <section class="youplay-banner banner-top youplay-banner-parallax small">

        <div class="image" data-speed="0.4">
            <img src="{{ $og_image }}" alt="{{ $title }}" class="jarallax-img">
        </div>


        <div class="info">
            <div>
                <div class="container">


                    <h1 class="h1">{{ $article_title }}</h1>


                </div>
            </div>
        </div>
    </section>
    <!-- /Banner -->
    <div class="container youplay-news">

        <!-- News List -->
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
                <!-- Post Share -->
                <div class="btn-group social-list social-likes" data-url="{{ $og_url }}"
                     data-counters="no">
                    <span class="btn btn-default facebook" title="Share link on Facebook"></span>
                    <span class="btn btn-default twitter" title="Share link on Twitter"></span>
                </div>
                <!-- /Post Share -->
            </article>

        </div>
        <!-- /News List -->

        <!-- Right Side -->
        <div class="col-md-3">

            {{ $widget }}

        </div>
        <!-- /Right Side -->

    </div>


    <x-hrace009::portal.footer/>


</div>


<x-hrace009::portal.bottom-script/>

{{-- Livewire Scripts --}}
@livewireScripts

</body>
</html>
