<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Theme CSS -->
    <link href="{{ route('theme.css') }}" rel="stylesheet">
    
    <!-- Mobile specific styles -->
    <style>
        /* Ensure the theme is applied to mobile layout */
        .mobile-layout {
            width: 100%;
            min-height: 100vh;
        }
    </style>

    @livewireStyles
</head>
<body class="mobile-layout @yield('body-class', 'mobile-page')">
    <!-- Mobile Header -->
    <header class="mobile-header">
        <div class="mobile-logo">
            <a href="{{ route('dashboard') }}">
                @if(config('pw-config.logo'))
                    <img src="{{ asset(config('pw-config.logo')) }}" alt="{{ config('app.name') }}">
                @else
                    <span style="color: var(--text-primary); font-weight: bold;">{{ config('app.name') }}</span>
                @endif
            </a>
        </div>
        
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <span></span>
        </button>
    </header>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav" id="mobileNav">
        <ul class="mobile-nav-list">
            <li class="mobile-nav-item">
                <a href="{{ route('dashboard') }}" class="mobile-nav-link">
                    <i class="fas fa-home"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>
            
            @if(config('pw-config.system.apps.shop'))
            <li class="mobile-nav-item">
                <a href="{{ route('app.shop.index') }}" class="mobile-nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    {{ __('Shop') }}
                </a>
            </li>
            @endif
            
            @if(config('pw-config.system.apps.donate'))
            <li class="mobile-nav-item">
                <a href="{{ route('app.donate.index') }}" class="mobile-nav-link">
                    <i class="fas fa-donate"></i>
                    {{ __('Donate') }}
                </a>
            </li>
            @endif
            
            @if(config('pw-config.system.apps.vote'))
            <li class="mobile-nav-item">
                <a href="{{ route('app.vote.index') }}" class="mobile-nav-link">
                    <i class="fas fa-vote-yea"></i>
                    {{ __('Vote') }}
                </a>
            </li>
            @endif
            
            @if(config('pw-config.system.apps.voucher'))
            <li class="mobile-nav-item">
                <a href="{{ route('app.voucher.index') }}" class="mobile-nav-link">
                    <i class="fas fa-ticket-alt"></i>
                    {{ __('Voucher') }}
                </a>
            </li>
            @endif
            
            @if(config('pw-config.system.apps.ranking'))
            <li class="mobile-nav-item">
                <a href="{{ route('app.ranking.index') }}" class="mobile-nav-link">
                    <i class="fas fa-trophy"></i>
                    {{ __('Rankings') }}
                </a>
            </li>
            @endif
            
            <li class="mobile-nav-item">
                <a href="{{ route('profile.show') }}" class="mobile-nav-link">
                    <i class="fas fa-user"></i>
                    {{ __('Profile') }}
                </a>
            </li>
            
            @if(auth()->user()->isAdministrator())
            <li class="mobile-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">
                    <i class="fas fa-cog"></i>
                    {{ __('Admin Panel') }}
                </a>
            </li>
            @endif
            
            <li class="mobile-nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-link" style="width: 100%; text-align: left; background: none; border: none;">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('Logout') }}
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    
    <!-- Mobile Nav Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

    <!-- Main Content -->
    <main class="mobile-content has-bottom-nav">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <a href="{{ route('dashboard') }}" class="mobile-bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        
        @if(config('pw-config.system.apps.shop'))
        <a href="{{ route('app.shop.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('app.shop.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Shop</span>
        </a>
        @endif
        
        @if(config('pw-config.system.apps.vote'))
        <a href="{{ route('app.vote.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('app.vote.*') ? 'active' : '' }}">
            <i class="fas fa-vote-yea"></i>
            <span>Vote</span>
        </a>
        @endif
        
        <a href="{{ route('profile.show') }}" class="mobile-bottom-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </nav>

    @livewireScripts
    
    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobileMenuBtn');
            const nav = document.getElementById('mobileNav');
            const overlay = document.getElementById('mobileNavOverlay');
            
            function toggleMenu() {
                menuBtn.classList.toggle('active');
                nav.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = nav.classList.contains('active') ? 'hidden' : '';
            }
            
            menuBtn.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
            
            // Close menu when clicking a link
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (!this.closest('form')) {
                        toggleMenu();
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>