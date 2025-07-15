@extends('layouts.website')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.nav.donate'))

@section('styles')
    <style>
        /* Donate specific styles */
        .donate-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .donation-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .donation-method {
            background: var(--surface-color);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .donation-method:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .method-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        
        .method-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 15px;
        }
        
        .method-description {
            color: var(--accent-color);
            font-size: 0.95rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .method-rate {
            font-size: 1.2rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .donate-button {
            background: var(--button-gradient);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .donate-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px var(--particle-shadow);
        }
        
        .donate-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .donate-info {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .donate-info h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .donate-info p {
            color: var(--accent-color);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .donation-methods {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .donation-method {
                padding: 20px;
            }
        }
    </style>
@endsection

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
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
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

    <!-- Donate Content -->
    <div class="content-section">
        <div class="donate-content">
            <h2 class="page-title" style="color: var(--primary-color); text-align: center; margin-bottom: 30px;">{{ __('site.donate.title') }}</h2>
            
            <div class="donate-info">
                <h3>{{ __('site.donate.support_title') }}</h3>
                <p>{{ __('site.donate.support_description') }}</p>
            </div>
            
            <div class="donation-methods">
                @php
                    $paypalEnabled = config('pw-config.payment.paypal.enabled', false);
                    $bankEnabled = config('pw-config.payment.bank_transfer.enabled', false);
                    $paymentwallEnabled = config('pw-config.payment.paymentwall.enabled', false);
                    $ipaymuEnabled = config('pw-config.payment.ipaymu.enabled', false);
                @endphp
                
                @if($paypalEnabled)
                <div class="donation-method">
                    <div class="method-icon">
                        <i class="fab fa-paypal"></i>
                    </div>
                    <div class="method-name">PayPal</div>
                    <div class="method-description">{{ __('site.donate.paypal_description') }}</div>
                    <div class="method-rate">
                        $1 = {{ config('pw-config.payment.paypal.rate', 100) }} {{ config('pw-config.currency_name', 'Points') }}
                    </div>
                    <a href="{{ route('donate.paypal') }}" class="donate-button">{{ __('site.donate.donate_now') }}</a>
                </div>
                @endif
                
                @if($bankEnabled)
                <div class="donation-method">
                    <div class="method-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="method-name">{{ __('site.donate.bank_transfer') }}</div>
                    <div class="method-description">{{ __('site.donate.bank_description') }}</div>
                    <div class="method-rate">
                        $1 = {{ config('pw-config.payment.bank_transfer.rate', 100) }} {{ config('pw-config.currency_name', 'Points') }}
                    </div>
                    <a href="{{ route('donate.bank') }}" class="donate-button">{{ __('site.donate.donate_now') }}</a>
                </div>
                @endif
                
                @if($paymentwallEnabled)
                <div class="donation-method">
                    <div class="method-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="method-name">Paymentwall</div>
                    <div class="method-description">{{ __('site.donate.paymentwall_description') }}</div>
                    <div class="method-rate">
                        $1 = {{ config('pw-config.payment.paymentwall.rate', 100) }} {{ config('pw-config.currency_name', 'Points') }}
                    </div>
                    <a href="{{ route('donate.paymentwall') }}" class="donate-button">{{ __('site.donate.donate_now') }}</a>
                </div>
                @endif
                
                @if($ipaymuEnabled)
                <div class="donation-method">
                    <div class="method-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="method-name">iPaymu</div>
                    <div class="method-description">{{ __('site.donate.ipaymu_description') }}</div>
                    <div class="method-rate">
                        $1 = {{ config('pw-config.payment.ipaymu.rate', 100) }} {{ config('pw-config.currency_name', 'Points') }}
                    </div>
                    <a href="{{ route('donate.ipaymu') }}" class="donate-button">{{ __('site.donate.donate_now') }}</a>
                </div>
                @endif
                
                @if(!$paypalEnabled && !$bankEnabled && !$paymentwallEnabled && !$ipaymuEnabled)
                <div class="donation-method" style="grid-column: 1 / -1;">
                    <div class="method-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="method-name">{{ __('site.donate.no_methods_title') }}</div>
                    <div class="method-description">{{ __('site.donate.no_methods_description') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $footerSettings = \App\Models\FooterSetting::first();
        $socialLinks = \App\Models\SocialLink::where('active', true)->orderBy('order')->get();
        $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Support our server to keep the adventure alive</p>';
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
        // Add any donate-specific JavaScript here
        console.log('Donate page loaded');
    </script>
@endsection