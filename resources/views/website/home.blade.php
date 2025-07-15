@extends('layouts.website')

@section('title', 'Haven Perfect World')

@section('content')
    @php
        $api = new \hrace009\PerfectWorldAPI\API();
        $point = new \App\Models\Point();
        $onlinePlayer = $point->getOnlinePlayer();
        $onlineCount = $api->online ? ($onlinePlayer >= 100 ? $onlinePlayer + config('pw-config.fakeonline', 0) : $onlinePlayer) : 0;
    @endphp
    
    <!-- Server Status -->
    <div class="server-status" style="position: fixed; top: 20px; left: 20px; z-index: 100; padding: 10px 15px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); width: 220px;">
        <div class="status-indicator {{ $api->online ? 'online' : 'offline' }}">
            <span class="status-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; animation: pulse 2s infinite; {{ $api->online ? 'background: #10b981; box-shadow: 0 0 10px #10b981;' : 'background: #ef4444; box-shadow: 0 0 10px #ef4444;' }}"></span>
            <span class="status-text" style="margin-left: 8px; font-weight: 600;">Server {{ $api->online ? 'Online' : 'Offline' }}</span>
        </div>
        @if($api->online)
            <div class="players-online" style="margin-top: 5px; font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-users"></i> {{ $onlineCount }} {{ $onlineCount == 1 ? 'Player' : 'Players' }} Online
            </div>
        @endif
    </div>
    
    <!-- Login/User Box -->
    <div class="login-box-wrapper" style="position: fixed; top: 100px; left: 20px; z-index: 100; width: 220px;">
        <div class="login-box collapsed" id="loginBox" style="border-radius: 10px; padding: 0; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); max-height: 400px; overflow-y: auto;">
            <div class="login-box-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-bottom: 1px solid var(--border-color); cursor: pointer;" onclick="toggleLoginBox()">
                <h3 style="margin: 0; font-size: 1rem;">@if(Auth::check()) {{ __('site.user_menu.account') }} @else {{ __('site.login.member_login') }} @endif</h3>
                <button class="collapse-toggle" style="background: none; border: none; font-size: 0.9rem; cursor: pointer; padding: 3px;">▼</button>
            </div>
            <div class="login-box-content" style="padding: 15px; max-height: 300px; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease;">
                @if(Auth::check())
                    <div class="user-info" style="text-align: center;">
                        <h3 style="margin-bottom: 15px;">{{ __('site.user_menu.welcome_back') }}</h3>
                        <div class="user-name" style="font-size: 0.95rem; margin-bottom: 10px; font-weight: 600;">{{ Auth::user()->truename ?? Auth::user()->name }}</div>
                        <div class="user-links" style="display: flex; flex-direction: column; gap: 5px;">
                            @if(config('pw-config.player_dashboard_enabled', true))
                            <a href="{{ route('app.dashboard') }}" class="user-link" style="padding: 6px 8px; border-radius: 8px; text-decoration: none; text-align: center; font-size: 0.85rem;">{{ __('site.user_menu.my_dashboard') }}</a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="user-link" style="padding: 6px 8px; border-radius: 8px; text-decoration: none; text-align: center; font-size: 0.85rem;">{{ __('site.user_menu.my_profile') }}</a>
                            @if(Auth::user()->isAdministrator())
                            <a href="{{ route('admin.dashboard') }}" class="user-link" style="padding: 6px 8px; border-radius: 8px; text-decoration: none; text-align: center; font-size: 0.85rem;">{{ __('site.user_menu.admin_panel') }}</a>
                            @endif
                            @if(Auth::user()->isGamemaster())
                            <a href="{{ route('gm.dashboard') }}" class="user-link" style="padding: 6px 8px; border-radius: 8px; text-decoration: none; text-align: center; font-size: 0.85rem;">{{ __('site.user_menu.gm_panel') }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="login-button" style="width: 100%; padding: 8px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; margin-bottom: 8px;">{{ __('site.login.logout') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <h3 style="margin-bottom: 15px; text-align: center;">{{ __('site.login.member_login') }}</h3>
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <input type="text" name="name" placeholder="{{ __('site.login.username') }}" required autofocus style="width: 100%; padding: 8px 12px; margin-bottom: 10px; border-radius: 8px; font-size: 0.9rem;">
                        <input type="password" name="password" placeholder="{{ __('site.login.password') }}" required style="width: 100%; padding: 8px 12px; margin-bottom: 10px; border-radius: 8px; font-size: 0.9rem;">
                        <input type="password" name="pin" placeholder="{{ __('site.login.pin') }}" id="pin-field" style="display: none; width: 100%; padding: 8px 12px; margin-bottom: 10px; border-radius: 8px; font-size: 0.9rem;">
                        <button type="submit" class="login-button" style="width: 100%; padding: 8px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; margin-bottom: 8px;">{{ __('site.login.login_button') }}</button>
                    </form>
                    <div class="login-links" style="text-align: center; margin-top: 10px;">
                        <a href="{{ route('register') }}" style="font-size: 0.85rem; margin: 0 8px;">{{ __('site.login.register') }}</a>
                        <a href="{{ route('password.request') }}" style="font-size: 0.85rem; margin: 0 8px;">{{ __('site.login.forgot_password') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @php
        $headerSettings = \App\Models\HeaderSetting::first();
        $headerContent = $headerSettings ? $headerSettings->content : '<div class="logo-container">
    <h1 class="logo">Haven Perfect World</h1>
    <p class="tagline">Embark on the Path of Immortals</p>
</div>';
        $headerAlignment = $headerSettings ? $headerSettings->alignment : 'center';
    @endphp
    
    <div class="header header-{{ $headerAlignment }}">
        <div class="mystical-border"></div>
        <a href="{{ route('HOME') }}" style="text-decoration: none; color: inherit;">
            {!! $headerContent !!}
        </a>
    </div>

    <nav class="nav-bar">
        <div class="nav-links">
            <a href="{{ route('HOME') }}" class="nav-link {{ Route::is('HOME') ? 'active' : '' }}">{{ __('site.nav.home') }}</a>
            
            @if( config('pw-config.system.apps.shop') )
            <a href="{{ route('public.shop') }}" class="nav-link {{ Route::is('public.shop') ? 'active' : '' }}">{{ __('site.nav.shop') }}</a>
            @endif
            
            @if( config('pw-config.system.apps.donate') )
            <a href="{{ route('public.donate') }}" class="nav-link {{ Route::is('public.donate') ? 'active' : '' }}">{{ __('site.nav.donate') }}</a>
            @endif
            
            @if( config('pw-config.system.apps.ranking') )
            <a href="{{ route('public.rankings') }}" class="nav-link {{ Route::is('public.rankings') ? 'active' : '' }}">{{ __('site.nav.rankings') }}</a>
            @endif
            
            @if( config('pw-config.system.apps.vote') )
            <a href="{{ route('public.vote') }}" class="nav-link {{ Route::is('public.vote') ? 'active' : '' }}">{{ __('site.nav.vote') }}</a>
            @endif
            
            @isset($download)
                @if( $download->exists() && $download->count() > 0 )
                    <a href="{{ route('show.article', $download->first()->slug ) }}" class="nav-link">Download</a>
                @endif
            @endisset
            
            @php
                $pages = \App\Models\Page::where('active', true)->orderBy('title')->get();
            @endphp
            @if($pages->count() > 0)
                <div class="nav-dropdown">
                    <a href="#" class="nav-link dropdown-toggle" onclick="event.preventDefault(); this.parentElement.classList.toggle('active');">
                        {{ __('site.nav.pages') }} <span class="dropdown-arrow">▼</span>
                    </a>
                    <div class="dropdown-menu">
                        @foreach($pages as $page)
                            <a href="{{ route('page.show', $page->slug) }}" class="dropdown-item">{{ $page->title }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <a href="{{ route('public.members') }}" class="nav-link {{ Route::is('public.members') ? 'active' : '' }}">{{ __('site.nav.members') }}</a>
        </div>
        
        @livewire('hrace009::language-selector')
    </nav>

    <!-- Main Content -->
    <div class="content-section">
        <!-- Add your main content here -->
        <h2>Welcome to Haven Perfect World</h2>
        <p>This is the main content area using the new theme system.</p>
    </div>

    @php
        $footerSettings = \App\Models\FooterSetting::first();
        $socialLinks = \App\Models\SocialLink::where('active', true)->orderBy('order')->get();
        $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Begin your journey through the realms of endless cultivation</p>';
        $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.';
        $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
    @endphp
    <div class="footer footer-{{ $footerAlignment }}">
        <div class="footer-container">
            <div class="footer-content-section">
                {!! $footerContent !!}
                <p class="footer-text">{!! $footerCopyright !!}</p>
            </div>
            
            @if($socialLinks->count() > 0)
            <div class="social-links">
                @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" class="social-link" target="_blank" rel="noopener noreferrer" title="{{ $link->platform }}">
                        <i class="{{ $link->icon }}"></i>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Login box collapse functionality
        function toggleLoginBox() {
            const loginBox = document.getElementById('loginBox');
            loginBox.classList.toggle('collapsed');
            
            // Save state to localStorage
            const isCollapsed = loginBox.classList.contains('collapsed');
            localStorage.setItem('loginBoxCollapsed', isCollapsed);
        }

        // Restore login box state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const loginBox = document.getElementById('loginBox');
            const savedState = localStorage.getItem('loginBoxCollapsed');
            
            if (savedState === 'false') {
                loginBox.classList.remove('collapsed');
            }
        });

        // Simple PIN check
        const usernameInput = document.querySelector('input[name="name"]');
        const pinField = document.getElementById('pin-field');
        
        if (usernameInput) {
            usernameInput.addEventListener('blur', function() {
                if (this.value.length > 2) {
                    pinField.style.display = 'block';
                }
            });
        }
    </script>
@endsection