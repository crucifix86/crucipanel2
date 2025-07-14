<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('pw-config.server_name', 'Laravel') }} @yield('title')</title>

    @if( ! config('pw-config.logo') )
        <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}"/>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/logo/logo.png') }}"/>
    @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(config('pw-config.logo')) }}"/>
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
    @endif

    <x-hrace009::front.top-script/>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap');
        
        /* Override theme colors with mystical purple */
        :root {
            --primary: #9370db;
            --primary-darker: #7b5ec4;
            --primary-lighter: #a58ae6;
            --secondary: #8a2be2;
            --accent: #4b0082;
            --bg-primary: #1a0f2e;
            --bg-secondary: #2a1b3d;
            --bg-darker: #0a0514;
            --text-primary: #e6d7f0;
            --text-secondary: #b19cd9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cinzel', serif;
            background: radial-gradient(ellipse at center, var(--bg-secondary) 0%, var(--bg-primary) 50%, var(--bg-darker) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        
        /* Mystical Background */
        .mystical-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            background: 
                radial-gradient(circle at 20% 30%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(75, 0, 130, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(148, 0, 211, 0.08) 0%, transparent 50%);
        }

        /* Floating Particles */
        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border-radius: 50%;
            opacity: 0.7;
            animation: float 8s infinite ease-in-out;
            box-shadow: 0 0 10px rgba(147, 112, 219, 0.5);
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            50% { 
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.7;
            }
        }

        /* Dragon Ornaments */
        .dragon-ornament {
            position: fixed;
            font-size: 8rem;
            opacity: 0.1;
            color: var(--primary);
            animation: dragonPulse 4s ease-in-out infinite;
            user-select: none;
            z-index: 1;
        }

        .dragon-left {
            top: 20%;
            left: -5%;
            transform: rotate(-15deg);
        }

        .dragon-right {
            bottom: 20%;
            right: -5%;
            transform: rotate(15deg) scaleX(-1);
        }

        @keyframes dragonPulse {
            0%, 100% { opacity: 0.1; transform: scale(1) rotate(-15deg); }
            50% { opacity: 0.2; transform: scale(1.1) rotate(-10deg); }
        }

        /* Main Layout Container */
        .app-container {
            position: relative;
            z-index: 10;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styling */
        .mystical-sidebar {
            width: 280px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(20px);
            border-right: 2px solid rgba(147, 112, 219, 0.4);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            position: relative;
        }

        .mystical-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(147, 112, 219, 0.1));
            pointer-events: none;
        }

        /* Header Styling */
        .mystical-header {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(147, 112, 219, 0.3));
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(147, 112, 219, 0.4);
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .mystical-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(147, 112, 219, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        /* Navigation Links */
        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(147, 112, 219, 0.2);
            padding-left: 35px;
        }

        .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(147, 112, 219, 0.4), transparent);
            border-left: 4px solid var(--primary);
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            margin-right: 15px;
        }

        /* Content Area */
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            position: relative;
        }

        /* Card Styling */
        .mystical-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .mystical-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary), var(--secondary), var(--accent));
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .mystical-card:hover::before {
            opacity: 0.3;
        }

        /* Button Styling */
        .mystical-btn {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mystical-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .mystical-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .mystical-btn:hover::before {
            left: 100%;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .mystical-sidebar {
                position: fixed;
                left: -280px;
                height: 100vh;
                z-index: 90;
                transition: left 0.3s ease;
            }
            
            .mystical-sidebar.open {
                left: 0;
            }
            
            .content-wrapper {
                margin-left: 0;
            }
        }

        /* Widget Area */
        .widget-area {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 20px;
        }

        /* Character Selector */
        .character-selector {
            background: rgba(147, 112, 219, 0.2);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 8px 15px;
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .character-selector:hover {
            background: rgba(147, 112, 219, 0.3);
            border-color: var(--primary);
        }

        /* Balance Display */
        .balance-display {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.2), rgba(138, 43, 226, 0.2));
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .balance-display .currency-icon {
            width: 24px;
            height: 24px;
            filter: drop-shadow(0 0 5px rgba(147, 112, 219, 0.8));
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="mystical-sidebar" id="sidebar">
            <x-hrace009::loading>
                {{ __('general.loading') }}
            </x-hrace009::loading>

            <!-- Sidebar Header -->
            <div class="p-6 text-center">
                <x-hrace009::brand>
                    <x-slot name="brand">
                        {{ config('pw-config.server_name') }}
                    </x-slot>
                </x-hrace009::brand>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 pb-4">
                <x-hrace009::front.dashboard-link/>
                @if( config('pw-config.system.apps.shop') )
                    <x-hrace009::front.shop-link/>
                @endif

                @if( config('pw-config.system.apps.donate') )
                    <x-hrace009::front.donate-link/>
                @endif

                @if( config('pw-config.system.apps.vote') )
                    <x-hrace009::front.vote-link/>
                @endif

                @if( config('pw-config.system.apps.voucher') )
                    <x-hrace009::front.voucher-link/>
                @endif

                @if ( config('pw-config.system.apps.inGameService') )
                    <x-hrace009::front.services-link/>
                @endif

                @if( config('pw-config.system.apps.ranking') )
                    <x-hrace009::front.ranking-link/>
                @endif
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-purple-800">
                <x-hrace009::side-bar-footer/>
            </div>
        </aside>

        <!-- Content Area -->
        <div class="content-wrapper">
            <!-- Header -->
            @php
                $headerSettings = \App\Models\HeaderSetting::first();
                $headerLogo = $headerSettings && $headerSettings->header_logo ? $headerSettings->header_logo : config('pw-config.header_logo', 'img/logo/haven_perfect_world_logo.svg');
                $badgeLogo = $headerSettings && $headerSettings->badge_logo ? $headerSettings->badge_logo : config('pw-config.badge_logo', 'img/logo/crucifix_logo.svg');
            @endphp
            <header class="mystical-header">
                <div class="header-content">
                    <img src="{{ asset($headerLogo) }}" alt="{{ config('pw-config.server_name') }}" class="user-header-logo" onclick="window.location.href='{{ route('HOME') }}'" style="cursor: pointer;">
                    <img src="{{ asset($badgeLogo) }}" alt="Badge" class="user-badge-logo">
                </div>
            </header>

            <!-- Navigation Bar -->
            <x-hrace009::nav-bar>
                <x-slot name="navmenu">
                    <x-hrace009::mobile-menu-button/>
                    <x-hrace009::brand>
                        <x-slot name="brand">
                            {{ config('pw-config.server_name') }}
                        </x-slot>
                    </x-hrace009::brand>
                    <x-hrace009::mobile-sub-menu-button/>
                    <x-hrace009::desktop-right-button>
                        <x-slot name="button">
                            @livewire('theme-selector')
                            <x-hrace009::dark-theme-button/>
                            <x-hrace009::language-button/>
                            <x-hrace009::character-selector/>
                            <x-hrace009::balance/>
                            <x-hrace009::admin-button/>
                            <x-hrace009::gm-button/>
                            <x-hrace009::site-button/>
                            <x-hrace009::user-avatar/>
                        </x-slot>
                    </x-hrace009::desktop-right-button>
                    <x-hrace009.mobile-sub-menu>
                        <x-slot name="button">
                            @livewire('theme-selector')
                            <x-hrace009::dark-theme-button/>
                            <x-hrace009::mobile-language-menu/>
                            <x-hrace009::character-selector/>
                            <x-hrace009::admin-button/>
                            <x-hrace009::site-button/>
                            <x-hrace009::mobile-user-avatar/>
                        </x-slot>
                    </x-hrace009.mobile-sub-menu>
                </x-slot>
                <x-slot name="navMobilMenu">
                    <x-hrace009.mobile-main-menu>
                        <x-slot name="links">
                            <x-hrace009::front.dashboard-link/>
                            @if( config('pw-config.system.apps.shop') )
                                <x-hrace009::front.shop-link/>
                            @endif

                            @if( config('pw-config.system.apps.donate') )
                                <x-hrace009::front.donate-link/>
                            @endif

                            @if( config('pw-config.system.apps.vote') )
                                <x-hrace009::front.vote-link/>
                            @endif

                            @if( config('pw-config.system.apps.voucher') )
                                <x-hrace009::front.voucher-link/>
                            @endif

                            @if ( config('pw-config.system.apps.inGameService') )
                                <x-hrace009::front.services-link/>
                            @endif

                            @if( config('pw-config.system.apps.ranking') )
                                <x-hrace009::front.ranking-link/>
                            @endif
                        </x-slot>
                    </x-hrace009.mobile-main-menu>
                </x-slot>
            </x-hrace009::nav-bar>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Content Header -->
                @if (isset($header))
                    <div class="mystical-card">
                        {{ $header }}
                    </div>
                @endif

                <!-- Content Area -->
                <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                    <div class="xl:col-span-3">
                        {{ $content }}
                    </div>
                    <div class="xl:col-span-1">
                        <div class="widget-area">
                            <x-hrace009::front.widget/>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <x-hrace009::footer/>
        </div>
    </div>

    <!-- Settings Panel -->
    <x-hrace009::settings-panel/>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.querySelector('.floating-particles');
            const numberOfParticles = 60;

            for (let i = 0; i < numberOfParticles; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 6 + 6) + 's';
                
                const colors = ['#9370db', '#8a2be2', '#4b0082', '#6a5acd'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
                particle.style.boxShadow = `0 0 10px ${color}`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Initialize particles
        createParticles();
    </script>

    @yield('footer')
    <x-hrace009::front.bottom-script/>
</body>
</html>