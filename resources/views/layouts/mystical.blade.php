<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('pw-config.server_name', 'Haven Perfect World'))</title>
    
    @if( ! config('pw-config.logo') )
        <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}"/>
    @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
    @endif
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ route('theme.css') }}?v={{ time() }}">
    @yield('styles')
    @livewireStyles
</head>
<body class="@yield('body-class', '')">
    <!-- Fixed Position Widgets - Outside Container -->
    @php
        $api = new \hrace009\PerfectWorldAPI\API();
        $point = new \App\Models\Point();
        $onlinePlayer = $point->getOnlinePlayer();
        $onlineCount = $api->online ? ($onlinePlayer >= 100 ? $onlinePlayer + config('pw-config.fakeonline', 0) : $onlinePlayer) : 0;
    @endphp
    
    <!-- Server Status -->
    <div class="server-status">
        <div class="status-indicator {{ $api->online ? 'online' : 'offline' }}">
            <span class="status-dot"></span>
            <span class="status-text">{{ $api->online ? __('site.server.online') : __('site.server.offline') }}</span>
        </div>
        @if($api->online)
            <div class="players-online">
                <i class="fas fa-users"></i> {{ trans_choice('site.server.players_online', $onlineCount, ['count' => $onlineCount]) }}
            </div>
        @endif
    </div>
    
    <!-- Login/User Box -->
    <div class="login-box-wrapper">
        <div class="login-box collapsed" id="loginBox">
            <div class="login-box-header" onclick="toggleLoginBox()">
                <h3>@if(Auth::check()) {{ __('site.login.account') }} @else {{ __('site.login.member_login') }} @endif</h3>
                <button class="collapse-toggle">▼</button>
            </div>
            <div class="login-box-content">
                @if(Auth::check())
                    <div class="user-info">
                        <h3>{{ __('site.login.welcome_back') }}</h3>
                        <div class="user-name">{{ Auth::user()->truename ?? Auth::user()->name }}</div>
                        <div class="user-links">
                            @if(config('pw-config.player_dashboard_enabled', true))
                            <a href="{{ route('app.dashboard') }}" class="user-link">{{ __('site.user_menu.my_dashboard') }}</a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="user-link">{{ __('site.user_menu.my_profile') }}</a>
                            @if(Auth::user()->isAdministrator())
                            <a href="{{ route('admin.dashboard') }}" class="user-link">{{ __('site.user_menu.admin_panel') }}</a>
                            @endif
                            @if(Auth::user()->isGamemaster())
                            <a href="{{ route('gm.dashboard') }}" class="user-link">{{ __('site.user_menu.gm_panel') }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="login-button">{{ __('site.login.logout') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <h3>{{ __('site.login.member_login') }}</h3>
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <input type="text" name="name" placeholder="{{ __('site.login.username') }}" required autofocus>
                        <input type="password" name="password" placeholder="{{ __('site.login.password') }}" required>
                        <input type="password" name="pin" placeholder="{{ __('site.login.pin') }}" id="pin-field" style="display: none;">
                        <button type="submit" class="login-button">{{ __('site.login.login_button') }}</button>
                    </form>
                    <div class="login-links">
                        <a href="{{ route('register') }}">{{ __('site.login.register') }}</a>
                        <a href="{{ route('password.request') }}">{{ __('site.login.forgot_password') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Visit Reward Widget -->
    @php
        $visitRewardSettings = \App\Models\VisitRewardSetting::first();
    @endphp
    
    @if($visitRewardSettings && $visitRewardSettings->enabled && Auth::check())
    @php
        $user = Auth::user();
        $lastClaim = \App\Models\VisitRewardLog::where('user_id', $user->ID)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $canClaim = true;
        $secondsUntilNext = 0;
        
        if ($lastClaim) {
            $nextClaimTime = $lastClaim->created_at->addHours($visitRewardSettings->cooldown_hours);
            $canClaim = now()->gte($nextClaimTime);
            $secondsUntilNext = $canClaim ? 0 : $nextClaimTime->diffInSeconds(now());
        }
    @endphp
    <script>
        window.visitRewardData = {
            canClaim: {{ $canClaim ? 'true' : 'false' }},
            secondsUntilNext: {{ $secondsUntilNext }},
            userId: {{ $user->ID }}
        };
        window.visitRewardTranslations = {
            checkIn: "{{ __('site.visit_reward.check_in') }}",
            claimed: "{{ __('site.visit_reward.claimed') }}",
            claiming: "{{ __('site.visit_reward.claiming') }}",
            error: "{{ __('site.visit_reward.error') }}",
            rewardClaimed: "{{ __('site.visit_reward.reward_claimed') }}"
        };
    </script>
    <div class="visit-reward-wrapper">
        <div class="visit-reward-box" id="visitRewardBox">
            <div class="visit-reward-header" onclick="toggleVisitRewardBox()">
                <h3>{{ __('site.visit_reward.title') }}</h3>
                <button class="collapse-toggle">▼</button>
            </div>
            <div class="visit-reward-content">
                <span class="reward-icon">🎁</span>
                <p class="reward-description">{{ __('site.visit_reward.description') }}</p>
                <div class="reward-amount">
                    +{{ $visitRewardSettings->reward_amount }}
                    @if($visitRewardSettings->reward_type == 'virtual')
                        {{ config('pw-config.currency_name', 'Coins') }}
                    @elseif($visitRewardSettings->reward_type == 'cubi')
                        {{ __('site.visit_reward.gold') }}
                    @else
                        {{ __('site.visit_reward.bonus_points') }}
                    @endif
                </div>
                <button class="claim-button" id="claimRewardBtn" onclick="claimVisitReward()" disabled>
                    {{ __('site.visit_reward.loading') }}
                </button>
                <div class="reward-timer" id="rewardTimer" style="display: none;">
                    {{ __('site.visit_reward.next_reward') }} <span class="countdown-display" id="rewardCountdown">--:--:--</span>
                </div>
            </div>
        </div>
    </div>
    <div data-currency-name="{{ config('pw-config.currency_name', 'Coins') }}" style="display: none;"></div>
    @endif
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <!-- Background Effects -->
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Main Container -->
    <div class="container">
        <!-- Header -->
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
            <a href="{{ route('HOME') }}">
                {!! $headerContent !!}
            </a>
        </div>

        <!-- Navigation -->
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
        </nav>

        <!-- Page Content -->
        @yield('content')

        <!-- Footer -->
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
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ route('theme.js') }}"></script>
    @yield('scripts')
    @livewireScripts
    @yield('footer')
</body>
</html>